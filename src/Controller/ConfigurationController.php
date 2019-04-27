<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use App\Service\Helpers;
use App\Service\JwtAuth;
use App\Entity\NDays;
use App\Entity\NClassificationSubject;
use App\Entity\NTypesSubject;
use App\Entity\NRequirementsStudent;
use App\Entity\Cohort;
use App\Entity\Classroom;
use App\Entity\User;


class ConfigurationController extends AbstractController {
	
	/**
	 * @Route("/configuration/days/new", name="configuration_days_new", methods={"POST"})
	 */
	public function DaysRegistry(Request $request,Helpers $helpers, JwtAuth $jwtauth) {

		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);

		if ($auth_check) {
			$json = $request->request->get('form');
			$form = json_decode($json);

			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'El formulario no puede estar vació.',
	 		);

	 		if ($form != null) {
	 			$createdAt = new \Datetime('now');
	 			$identity = $jwtauth->checkToken($token, true);

	 			$name = (isset($form->name)) ? $form->name : null;

				if ($name != null) {
					$em = $this->getDoctrine()->getManager();
					$isset_day = $em->getRepository(NDays::class)->findBy(array('day' => $name));
					if (count($isset_day) == 0) {
						$NDays = new NDays();
						$NDays->setDay($name);
						$NDays->setCreateTime($createdAt);
						$user = $em->getRepository(User::class)->findOneById($identity->id);
						$NDays->setUser($user);
						$em->persist($NDays);
		    			$em->flush();
		    			$helpers->binnacleAction('NDays','registro',$createdAt,'Registrando día en el modulo configuración.',$identity->id);
						$response = array(
							'status' => 'success',
							'code' => 200,
							'msg' => 'Registro creado exitosamente.',
			 			);
					} else {
						$response = array(
							'status' => 'error',
							'code' => 400,
							'msg' => 'El registro ya se encuentra en base de datos.',
	 					);
					}
				}
	 		
	 		}
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}
		return $helpers->json($response);
	}


	/**
	 * @Route("/configuration/days", name="configuration_view_days", methods={"POST"})
	 */
	public function DaysView(Request $request,Helpers $helpers, JwtAuth $jwtauth) {

		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);
		$createdAt = new \Datetime('now');

		if ($auth_check) {
			$data = array();
			$em = $this->getDoctrine()->getManager();
			$identity = $jwtauth->checkToken($token, true);
			$days =  $em->getRepository(NDays::class)->findAll();
			foreach ($days as $key => $value) {
				$data[] = [
					'id' => $days[$key]->getId(),
					'name' => $days[$key]->getDay(),
				];
			}
			$helpers->binnacleAction('NDays','consulta',$createdAt,'Consultando lista de dias.',$identity->id);
			$response = array(
				'status' => 'success',
				'code' => 200,
				'data' => $data,
			);
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}

		return $helpers->json($response);
	}

	/**
	 * @Route("/configuration/get/data", name="configuration_get_data", methods={"POST"})
	 */
	public function DataGet(Request $request,Helpers $helpers, JwtAuth $jwtauth) {
		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);
		$createdAt = new \Datetime('now');

		if ($auth_check) {
			$em = $this->getDoctrine()->getManager();
			$id_data = $request->request->get('id');
			$table_find = $request->request->get('table');
			$identity = $jwtauth->checkToken($token, true);
			switch ($table_find) {
				case 'NDays':
					$NDays =  $em->getRepository(NDays::class)->findOneById($id_data);
					$data = [
						'id' => $NDays->getId(),
						'name' => $NDays->getDay(),
					];
					$helpers->binnacleAction('NDays','consulta',$createdAt,'Consultando lista de dias',$identity->id);
				break;				
				case 'NClassificationSubject':
					$NClassificationSubject =  $em->getRepository(NClassificationSubject::class)->findOneById($id_data);
					$data = [
						'id' => $NClassificationSubject->getId(),
						'name' => $NClassificationSubject->getName(),
					];
					$helpers->binnacleAction('NClassificationSubject','consulta',$createdAt,'Consultando lista de clasificaciones de asignatura',$identity->id);
				break;				
				case 'NTypesSubject':
					$NTypesSubject =  $em->getRepository(NTypesSubject::class)->findOneById($id_data);
					$data = [
						'id' => $NTypesSubject->getId(),
						'name' => $NTypesSubject->getName(),
					];
					$helpers->binnacleAction('NTypesSubject','consulta',$createdAt,'Consultando lista de tipos de asignatura',$identity->id);
				break;
				case 'NRequirementsStudent':
					$NRequirementsStudent =  $em->getRepository(NRequirementsStudent::class)->findOneById($id_data);
					$data = [
						'id' => $NRequirementsStudent->getId(),
						'name' => $NRequirementsStudent->getName(),
					];
					$helpers->binnacleAction('NRequirementsStudent','consulta',$createdAt,'Consultando lista de requisitos de estudiante',$identity->id);
				break;
			}
			$response = array(
				'status' => 'success',
				'code' => 200,
				'data' => $data,
			);
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}

		return $helpers->json($response);
	}

	/**
	 * @Route("/configuration/edit/data", name="configuration_edit_data", methods={"POST"})
	 */
	public function DataEdit(Request $request,Helpers $helpers, JwtAuth $jwtauth) {
		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);

		if ($auth_check) {
			$em = $this->getDoctrine()->getManager();
			$identity = $jwtauth->checkToken($token, true);
			$json = $request->request->get('form');
			$table_find = $request->request->get('table');
			$form = json_decode($json);
			
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'Error al actualizar, dato vacio.',
	 		);

 			$updateAt = new \Datetime('now');
	 		if ($json != null) {
	 			$name = (isset($form->name)) ? $form->name : null;
				if ($name != null) {
					switch ($table_find) {
						case 'NDays':
			 				$NDays =  $em->getRepository(NDays::class)->findOneById($form->id);
			 				$NDays->setDay($form->name);
			 				$NDays->setUpdateTime($updateAt);
							$em->persist($NDays);
							$em->flush();
							$helpers->binnacleAction('NDays','actualización',$updateAt,'Modificando datos de días.',$identity->id);
						break;						
						case 'NClassificationSubject':
		 					$entid =  $em->getRepository(NClassificationSubject::class)->findOneById($form->id);
			 				$entid->setName($form->name);
			 				$entid->setUpdateTime($updateAt);
							$em->persist($entid);
							$em->flush();
							$helpers->binnacleAction($table_find,'actualización',$updateAt,'Modificando datos de clasificación de asignatura.',$identity->id);
						break;						
						case 'NTypesSubject':
	 						$entid =  $em->getRepository(NTypesSubject::class)->findOneById($form->id);
			 				$entid->setName($form->name);
			 				$entid->setUpdateTime($updateAt);
							$em->persist($entid);
							$em->flush();
							$helpers->binnacleAction($table_find,'actualización',$updateAt,'Modificando datos de tipo de asignatura.',$identity->id);
						break;						
						case 'NRequirementsStudent':
	 						$entid =  $em->getRepository(NRequirementsStudent::class)->findOneById($form->id);
			 				$entid->setName($form->name);
			 				$entid->setUpdateTime($updateAt);
							$em->persist($entid);
							$em->flush();
							$helpers->binnacleAction($table_find,'actualización',$updateAt,'Modificando datos de requisito de estudiante.',$identity->id);
						break;
					}
	 				if ($table_find == '') {

	 				} elseif ($table_find =='') {

	 				}
	 				$response = array(
						'status' => 'success',
						'code' => 200,
						'msg' => 'Registro actualizado.'
		 			);
				}
	 		}
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}
		return $helpers->json($response);
	}

	/**
	 * @Route("/configuration/delete/data", name="configuration_delete_data", methods={"POST"})
	 */
	public function DataDelete(Request $request,Helpers $helpers, JwtAuth $jwtauth) {
		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);
		$createdAt = new \Datetime('now');

		if ($auth_check) {
			$em = $this->getDoctrine()->getManager();
			$json = $request->request->get('form');
			$table_find = $request->request->get('table');
			$form = json_decode($json);
			$identity = $jwtauth->checkToken($token, true);
			switch ($table_find) {
				case 'NDays':
					$Datas =  $em->getRepository(NDays::class)->findOneById($form->id);
					$helpers->binnacleAction('NDays','elimino',$createdAt,'Se elimino día ',$identity->id);	
				break;				
				case 'NClassificationSubject':
					$Datas =  $em->getRepository(NClassificationSubject::class)->findOneById($form->id);
					$helpers->binnacleAction('NClassificationSubject','elimino',$createdAt,'Se elimino clasificación de asignatura',$identity->id);
				break;				
				case 'NTypesSubject':
					$Datas =  $em->getRepository(NTypesSubject::class)->findOneById($form->id);
					$helpers->binnacleAction('NTypesSubject','elimino',$createdAt,'Se elimino tipo de asignatura ',$identity->id);
				break;
				case 'NRequirementsStudent':
					$Datas =  $em->getRepository(NRequirementsStudent::class)->findOneById($form->id);
					$helpers->binnacleAction('NRequirementsStudent','elimino',$createdAt,'Se elimino requisito de estudiante.',$identity->id);
				break;
			}
			$em->remove($Datas);
			$em->flush();
			$response = array(
				'status' => 'success',
				'code' => 200,
				'msg' => 'Registro eliminado con exito.',
			);
			
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}

		return $helpers->json($response);
	}

	/**
	 * @Route("/configuration/nclasssubject/new", name="configuration_nclasssubject_new", methods={"POST"})
	 */
	public function ClassSubjectRegistry(Request $request,Helpers $helpers, JwtAuth $jwtauth) {

		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);

		if ($auth_check) {
			$json = $request->request->get('form');
			$form = json_decode($json);

			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'El formulario no puede estar vació.',
	 		);

	 		if ($form != null) {
	 			$createdAt = new \Datetime('now');
	 			$identity = $jwtauth->checkToken($token, true);

	 			$name = (isset($form->name)) ? $form->name : null;

				if ($name != null) {
					$em = $this->getDoctrine()->getManager();
					$isset_data = $em->getRepository(NClassificationSubject::class)->findBy(array('name' => $name));
					if (count($isset_data) == 0) {
						$NClassificationSubject = new NClassificationSubject();
						$NClassificationSubject->setName($name);
						$NClassificationSubject->setCreateTime($createdAt);
						$user = $em->getRepository(User::class)->findOneById($identity->id);
						$NClassificationSubject->setUser($user);
						$em->persist($NClassificationSubject);
		    			$em->flush();
		    			$helpers->binnacleAction('NClassificationSubject','registro',$createdAt,'Registrando clasificacion de asignatura.',$identity->id);
						$response = array(
							'status' => 'success',
							'code' => 200,
							'msg' => 'Registro creado exitosamente.',
			 			);
					} else {
						$response = array(
							'status' => 'error',
							'code' => 400,
							'msg' => 'El registro ya se encuentra en base de datos.',
	 					);
					}
				}
	 		
	 		}
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}
		return $helpers->json($response);
	}

	/**
	 * @Route("/configuration/nclasssubject", name="configuration_view_nclasssubject", methods={"POST"})
	 */
	public function ClassSubjectView(Request $request,Helpers $helpers, JwtAuth $jwtauth) {

		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);
		$createdAt = new \Datetime('now');

		if ($auth_check) {
			$data = array();
			$em = $this->getDoctrine()->getManager();
			$identity = $jwtauth->checkToken($token, true);
			$NClassificationSubject =  $em->getRepository(NClassificationSubject::class)->findAll();
			foreach ($NClassificationSubject as $key => $value) {
				$data[] = [
					'id' => $NClassificationSubject[$key]->getId(),
					'name' => $NClassificationSubject[$key]->getName(),
				];
			}
			$helpers->binnacleAction('NClassificationSubject','consulta',$createdAt,'Consultando lista de clasificaciones.',$identity->id);
			$response = array(
				'status' => 'success',
				'code' => 200,
				'data' => $data,
			);
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}

		return $helpers->json($response);
	}

	/**
	 * @Route("/configuration/typesubject/new", name="configuration_typesubject_new", methods={"POST"})
	 */
	public function TypeSubjectRegistry(Request $request,Helpers $helpers, JwtAuth $jwtauth) {

		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);

		if ($auth_check) {
			$json = $request->request->get('form');
			$form = json_decode($json);

			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'El formulario no puede estar vació.',
	 		);

	 		if ($form != null) {
	 			$createdAt = new \Datetime('now');
	 			$identity = $jwtauth->checkToken($token, true);

	 			$name = (isset($form->name)) ? $form->name : null;

				if ($name != null) {
					$em = $this->getDoctrine()->getManager();
					$isset_data = $em->getRepository(NTypesSubject::class)->findBy(array('name' => $name));
					if (count($isset_data) == 0) {
						$NTypesSubject = new NTypesSubject();
						$NTypesSubject->setName($name);
						$NTypesSubject->setCreateTime($createdAt);
						$user = $em->getRepository(User::class)->findOneById($identity->id);
						$NTypesSubject->setUser($user);
						$em->persist($NTypesSubject);
		    			$em->flush();
		    			$helpers->binnacleAction('NTypesSubject','registro',$createdAt,'Registrando tipo de asignatura.',$identity->id);
						$response = array(
							'status' => 'success',
							'code' => 200,
							'msg' => 'Registro creado exitosamente.',
			 			);
					} else {
						$response = array(
							'status' => 'error',
							'code' => 400,
							'msg' => 'El registro ya se encuentra en base de datos.',
	 					);
					}
				}
	 		
	 		}
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}
		return $helpers->json($response);
	}

	/**
	 * @Route("/configuration/typesubject", name="configuration_view_typesubject", methods={"POST"})
	 */
	public function TypeSubjectView(Request $request,Helpers $helpers, JwtAuth $jwtauth) {

		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);
		$createdAt = new \Datetime('now');

		if ($auth_check) {
			$data = array();
			$em = $this->getDoctrine()->getManager();
			$identity = $jwtauth->checkToken($token, true);
			$NTypesSubject =  $em->getRepository(NTypesSubject::class)->findAll();
			foreach ($NTypesSubject as $key => $value) {
				$data[] = [
					'id' => $NTypesSubject[$key]->getId(),
					'name' => $NTypesSubject[$key]->getName(),
				];
			}
			$helpers->binnacleAction('NTypesSubject','consulta',$createdAt,'Consultando lista de clasificaciones.',$identity->id);
			$response = array(
				'status' => 'success',
				'code' => 200,
				'data' => $data,
			);
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}

		return $helpers->json($response);
	}

	
	/**
	 * @Route("/configuration/requirementstudent/new", name="configuration_requirementstudent_new", methods={"POST"})
	 */
	public function RequirementStudentRegistry(Request $request,Helpers $helpers, JwtAuth $jwtauth) {

		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);

		if ($auth_check) {
			$json = $request->request->get('form');
			$form = json_decode($json);

			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'El formulario no puede estar vació.',
	 		);

	 		if ($form != null) {
	 			$createdAt = new \Datetime('now');
	 			$identity = $jwtauth->checkToken($token, true);

	 			$name = (isset($form->name)) ? $form->name : null;

				if ($name != null) {
					$em = $this->getDoctrine()->getManager();
					$isset_data = $em->getRepository(NRequirementsStudent::class)->findBy(array('name' => $name));
					if (count($isset_data) == 0) {
						$NRequirementsStudent = new NRequirementsStudent();
						$NRequirementsStudent->setName($name);
						$NRequirementsStudent->setCreateTime($createdAt);
						$user = $em->getRepository(User::class)->findOneById($identity->id);
						$NRequirementsStudent->setUser($user);
						$em->persist($NRequirementsStudent);
		    			$em->flush();
		    			$helpers->binnacleAction('NRequirementsStudent','registro',$createdAt,'Registrando requerimiento de estudiante.',$identity->id);
						$response = array(
							'status' => 'success',
							'code' => 200,
							'msg' => 'Registro creado exitosamente.',
			 			);
					} else {
						$response = array(
							'status' => 'error',
							'code' => 400,
							'msg' => 'El registro ya se encuentra en base de datos.',
	 					);
					}
				}
	 		
	 		}
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}
		return $helpers->json($response);
	}

	/**
	 * @Route("/configuration/requirementstudents", name="configuration_view_requirementstudent", methods={"POST"})
	 */
	public function RequirementStudentView(Request $request,Helpers $helpers, JwtAuth $jwtauth) {

		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);
		$createdAt = new \Datetime('now');

		if ($auth_check) {
			$data = array();
			$em = $this->getDoctrine()->getManager();
			$identity = $jwtauth->checkToken($token, true);
			$NRequirementsStudent =  $em->getRepository(NRequirementsStudent::class)->findAll();
			foreach ($NRequirementsStudent as $key => $value) {
				$data[] = [
					'id' => $NRequirementsStudent[$key]->getId(),
					'name' => $NRequirementsStudent[$key]->getName(),
				];
			}
			$helpers->binnacleAction('NRequirementsStudent','consulta',$createdAt,'Consultando lista de requerimientos de estudiante.',$identity->id);
			$response = array(
				'status' => 'success',
				'code' => 200,
				'data' => $data,
			);
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}

		return $helpers->json($response);
	}

	/**
	 * @Route("/configuration/cohort/new", name="configuration_cohort_new", methods={"POST"})
	 */
	public function CohortRegistry(Request $request,Helpers $helpers, JwtAuth $jwtauth) {

		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);

		if ($auth_check) {
			$json = $request->request->get('form');
			$form = json_decode($json);

			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'El formulario no puede estar vació.',
	 		);

	 		if ($form != null) {
	 			$createdAt = new \Datetime('now');
	 			$identity = $jwtauth->checkToken($token, true);

	 			$code = (isset($form->code)) ? $form->code : null;
	 			$initialDate = (isset($form->initialDate)) ? $form->initialDate : null;
	 			$finalDate = (isset($form->finalDate)) ? $form->finalDate : null;
	 			$year = (isset($form->year)) ? $form->year : null;
	 			$limit = (isset($form->limit)) ? $form->limit : null;

				if ($code != null) {
					$em = $this->getDoctrine()->getManager();
					$isset_data = $em->getRepository(Cohort::class)->findBy(array('code' => $code));
					if (count($isset_data) == 0) {
						$Cohort = new Cohort();
						$Cohort->setActive(1);
						$dateini = new \Datetime($initialDate);
						$Cohort->setInitialDate($dateini);
						$datefin = new \Datetime($finalDate);
						$Cohort->setFinalDate($datefin);
						$Cohort->setYear($year);
						$Cohort->setCode($code);
						$Cohort->setLimit($limit);
						$Cohort->setCreateTime($createdAt);
						$user = $em->getRepository(User::class)->findOneById($identity->id);
						$Cohort->setUser($user);
						$em->persist($Cohort);
		    			$em->flush();
		    			$helpers->binnacleAction('Cohort','registro',$createdAt,'Registrando cohorte '.$code.'.',$identity->id);
						$response = array(
							'status' => 'success',
							'code' => 200,
							'msg' => 'Registro creado exitosamente.',
			 			);
					} else {
						$response = array(
							'status' => 'error',
							'code' => 400,
							'msg' => 'El registro ya se encuentra en base de datos.',
	 					);
					}
				}
	 		}
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}
		return $helpers->json($response);
	}

	/**
	 * @Route("/configuration/cohort", name="configuration_view_cohort", methods={"POST"})
	 */
	public function CohortView(Request $request,Helpers $helpers, JwtAuth $jwtauth) {

		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);
		$createdAt = new \Datetime('now');

		if ($auth_check) {
			$data = array();
			$em = $this->getDoctrine()->getManager();
			$identity = $jwtauth->checkToken($token, true);
			$Cohort =  $em->getRepository(Cohort::class)->findAll();
			foreach ($Cohort as $key => $value) {
				$data[] = [
					'id' => $Cohort[$key]->getId(),
					'active' => $Cohort[$key]->getActive(),
					'initialDate' => $Cohort[$key]->getInitialDate(),
					'finalDate' => $Cohort[$key]->getFinalDate(),
					'year' => $Cohort[$key]->getYear(),
					'code' => $Cohort[$key]->getCode(),
				];
			}
			$helpers->binnacleAction('Cohort','consulta',$createdAt,'Consultando lista de cohortes.',$identity->id);
			$response = array(
				'status' => 'success',
				'code' => 200,
				'data' => $data,
			);
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}

		return $helpers->json($response);
	}

	/**
	 * @Route("/configuration/cohort/get", name="configuration_cohort_get", methods={"POST"})
	 */
	public function CohortGet(Request $request,Helpers $helpers, JwtAuth $jwtauth) {
		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);
		$createdAt = new \Datetime('now');

		if ($auth_check) {
			$em = $this->getDoctrine()->getManager();
			$id_data = $request->request->get('id');
			$identity = $jwtauth->checkToken($token, true);
			$Cohort =  $em->getRepository(Cohort::class)->findOneById($id_data);
			$data = [
				'id' => $Cohort->getId(),
				'active' => $Cohort->getActive(),
				'initialDate' => $Cohort->getInitialDate(),
				'finalDate' => $Cohort->getFinalDate(),
				'year' => $Cohort->getYear(),
				'code' => $Cohort->getCode(),
			];
			$helpers->binnacleAction('Cohort','consulta',$createdAt,'Consultando lista de cohortes',$identity->id);
			$response = array(
				'status' => 'success',
				'code' => 200,
				'data' => $data,
			);
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}

		return $helpers->json($response);
	}

	/**
	 * @Route("/configuration/edit/cohort", name="configuration_edit_cohort", methods={"POST"})
	 */
	public function CohortEdit(Request $request,Helpers $helpers, JwtAuth $jwtauth) {
		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);

		if ($auth_check) {
			$em = $this->getDoctrine()->getManager();
			$identity = $jwtauth->checkToken($token, true);
			$json = $request->request->get('form');
			$form = json_decode($json);
			
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'Error al actualizar, dato vacio.',
	 		);

 			$updateAt = new \Datetime('now');
	 		if ($json != null) {
	 			$code = (isset($form->code)) ? $form->code : null;
	 			$initialDate = (isset($form->initialDate)) ? $form->initialDate : null;
	 			$finalDate = (isset($form->finalDate)) ? $form->finalDate : null;
	 			$year = (isset($form->year)) ? $form->year : null;
	 			$active = (isset($form->active)) ? $form->active : null;
				if ($code != null) {
	 				$Cohort =  $em->getRepository(Cohort::class)->findOneById($form->id);
	 				if ($active == 'true') {
	 					$active_re = 1;
	 				} else {
	 					$active_re = 0;
	 				}
					//$Cohort->setCode($code);
					$Cohort->setActive($active_re);
					$dateini = new \Datetime($initialDate);
					$Cohort->setInitialDate($dateini);
					$datefin = new \Datetime($finalDate);
					$Cohort->setFinalDate($datefin);
					$Cohort->setYear($year);
	 				$Cohort->setUpdateTime($updateAt);
					$em->persist($Cohort);
					$em->flush();
					$helpers->binnacleAction('Cohort','actualización',$updateAt,'Modificando datos en cohortes.',$identity->id);
	 				$response = array(
						'status' => 'success',
						'code' => 200,
						'msg' => 'Registro actualizado.'
		 			);
				}
	 		}
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}
		return $helpers->json($response);
	}

	/**
	 * @Route("/configuration/delete/cohort", name="configuration_delete_cohort", methods={"POST"})
	 */
	public function CohortDelete(Request $request,Helpers $helpers, JwtAuth $jwtauth) {
		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);
		$createdAt = new \Datetime('now');

		if ($auth_check) {
			$em = $this->getDoctrine()->getManager();
			$json = $request->request->get('form');
			$form = json_decode($json);
			$identity = $jwtauth->checkToken($token, true);
			$Cohort =  $em->getRepository(Cohort::class)->findOneById($form->id);
			$helpers->binnacleAction('Cohort','elimino',$createdAt,'Se elimino cohorte ',$identity->id);	
			$em->remove($Cohort);
			$em->flush();
			$response = array(
				'status' => 'success',
				'code' => 200,
				'msg' => 'Registro eliminado.',
			);
			
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}

		return $helpers->json($response);
	}

	/**
	 * @Route("/configuration/classroom/new", name="configuration_classroom_new", methods={"POST"})
	 */
	public function ClassRoomRegistry(Request $request,Helpers $helpers, JwtAuth $jwtauth) {

		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);

		if ($auth_check) {
			$json = $request->request->get('form');
			$form = json_decode($json);

			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'El formulario no puede estar vació.',
	 		);

	 		if ($form != null) {
	 			$createdAt = new \Datetime('now');
	 			$identity = $jwtauth->checkToken($token, true);

	 			$edifice = (isset($form->edifice)) ? $form->edifice : null;
	 			$floor = (isset($form->floor)) ? $form->floor : null;
	 			$name = (isset($form->name)) ? $form->name : null;

				if ($edifice != null) {
					$em = $this->getDoctrine()->getManager();
					$isset_data = $em->getRepository(Classroom::class)->findBy(array('name' => $name));
					if (count($isset_data) == 0) {
						$Classroom = new Classroom();
						$Classroom->setEdifice($edifice);
						$Classroom->setFloor($floor);
						$Classroom->setName($name);
						$Classroom->setCreateTime($createdAt);
						$user = $em->getRepository(User::class)->findOneById($identity->id);
						$Classroom->setUser($user);
						$em->persist($Classroom);
		    			$em->flush();
		    			$helpers->binnacleAction('Classroom','registro',$createdAt,'Registrando aula '.$name.'.',$identity->id);
						$response = array(
							'status' => 'success',
							'code' => 200,
							'msg' => 'Registro creado exitosamente.',
			 			);
					} else {
						$response = array(
							'status' => 'error',
							'code' => 400,
							'msg' => 'El registro ya se encuentra en base de datos.',
	 					);
					}
				}
	 		
	 		}
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}
		return $helpers->json($response);
	}

	/**
	 * @Route("/configuration/classroom", name="configuration_view_classroom", methods={"POST"})
	 */
	public function ClassRoomView(Request $request,Helpers $helpers, JwtAuth $jwtauth) {

		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);
		$createdAt = new \Datetime('now');

		if ($auth_check) {
			$data = array();
			$em = $this->getDoctrine()->getManager();
			$identity = $jwtauth->checkToken($token, true);
			$Classroom =  $em->getRepository(Classroom::class)->findAll();
			foreach ($Classroom as $key => $value) {
				$data[] = [
					'id' => $Classroom[$key]->getId(),
					'edifice' => $Classroom[$key]->getEdifice(),
					'floor' => $Classroom[$key]->getFloor(),
					'name' => $Classroom[$key]->getName(),
				];
			}
			$helpers->binnacleAction('Classroom','consulta',$createdAt,'Consultando lista de aulas.',$identity->id);
			$response = array(
				'status' => 'success',
				'code' => 200,
				'data' => $data,
			);
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}

		return $helpers->json($response);
	}

	/**
	 * @Route("/configuration/edit/classroom", name="configuration_edit_classroom", methods={"POST"})
	 */
	public function ClassRoomEdit(Request $request,Helpers $helpers, JwtAuth $jwtauth) {
		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);

		if ($auth_check) {
			$em = $this->getDoctrine()->getManager();
			$identity = $jwtauth->checkToken($token, true);
			$json = $request->request->get('form');
			$form = json_decode($json);
			
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'Error al actualizar, dato vacio.',
	 		);

 			$updateAt = new \Datetime('now');
	 		if ($json != null) {
				$edifice = (isset($form->edifice)) ? $form->edifice : null;
	 			$floor = (isset($form->floor)) ? $form->floor : null;
	 			$name = (isset($form->name)) ? $form->name : null;
				if ($name != null) {
	 				$Classroom =  $em->getRepository(Classroom::class)->findOneById($form->id);
					$Classroom->setEdifice($edifice);
					$Classroom->setFloor($floor);
					$Classroom->setName($name);
	 				$Classroom->setUpdateTime($updateAt);
					$em->persist($Classroom);
					$em->flush();
					$helpers->binnacleAction('Classroom','actualización',$updateAt,'Modificando datos en aulas.',$identity->id);
	 				$response = array(
						'status' => 'success',
						'code' => 200,
						'msg' => 'Registro actualizado.'
		 			);
				}
	 		}
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}
		return $helpers->json($response);
	}

	/**
	 * @Route("/configuration/classroom/get", name="configuration_classroom_get", methods={"POST"})
	 */
	public function ClassRoomGet(Request $request,Helpers $helpers, JwtAuth $jwtauth) {
		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);
		$createdAt = new \Datetime('now');

		if ($auth_check) {
			$em = $this->getDoctrine()->getManager();
			$id_data = $request->request->get('id');
			$identity = $jwtauth->checkToken($token, true);
			$Classroom =  $em->getRepository(Classroom::class)->findOneById($id_data);
			$data = [
				'id' => $Classroom->getId(),
				'edifice' => $Classroom->getEdifice(),
				'floor' => $Classroom->getFloor(),
				'name' => $Classroom->getName(),
			];
			$helpers->binnacleAction('Classroom','consulta',$createdAt,'Consultando lista de aulas',$identity->id);
			$response = array(
				'status' => 'success',
				'code' => 200,
				'data' => $data,
			);
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}

		return $helpers->json($response);
	}

	/**
	 * @Route("/configuration/delete/classroom", name="configuration_delete_classroom", methods={"POST"})
	 */
	public function ClassRoomDelete(Request $request,Helpers $helpers, JwtAuth $jwtauth) {
		$token = $request->request->get('authorization', null);
		$auth_check = $jwtauth->checkToken($token);
		$createdAt = new \Datetime('now');

		if ($auth_check) {
			$em = $this->getDoctrine()->getManager();
			$json = $request->request->get('form');
			$form = json_decode($json);
			$identity = $jwtauth->checkToken($token, true);
			$ClassRoom =  $em->getRepository(ClassRoom::class)->findOneById($form->id);
			$helpers->binnacleAction('ClassRoom','elimino',$createdAt,'Se elimino aula ',$identity->id);	
			$em->remove($ClassRoom);
			$em->flush();
			$response = array(
				'status' => 'success',
				'code' => 200,
				'data' => 'Registro eliminado.',
			);
			
		} else {
			$response = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'No tiene acceso.',
			);
		}

		return $helpers->json($response);
	}
}


