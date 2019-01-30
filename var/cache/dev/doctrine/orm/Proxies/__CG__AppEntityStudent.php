<?php

namespace Proxies\__CG__\App\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Student extends \App\Entity\Student implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'id', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'name', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'name2', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'surname', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'surname2', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'email', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'phone', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'identification', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'admitted', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'createTime', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'updateTime', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'user'];
        }

        return ['__isInitialized__', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'id', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'name', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'name2', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'surname', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'surname2', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'email', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'phone', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'identification', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'admitted', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'createTime', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'updateTime', '' . "\0" . 'App\\Entity\\Student' . "\0" . 'user'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Student $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId(): ?int
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', []);

        return parent::getName();
    }

    /**
     * {@inheritDoc}
     */
    public function setName(?string $name): \App\Entity\Student
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setName', [$name]);

        return parent::setName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getName2(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName2', []);

        return parent::getName2();
    }

    /**
     * {@inheritDoc}
     */
    public function setName2(?string $name2): \App\Entity\Student
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setName2', [$name2]);

        return parent::setName2($name2);
    }

    /**
     * {@inheritDoc}
     */
    public function getSurname(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSurname', []);

        return parent::getSurname();
    }

    /**
     * {@inheritDoc}
     */
    public function setSurname(?string $surname): \App\Entity\Student
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSurname', [$surname]);

        return parent::setSurname($surname);
    }

    /**
     * {@inheritDoc}
     */
    public function getSurname2(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSurname2', []);

        return parent::getSurname2();
    }

    /**
     * {@inheritDoc}
     */
    public function setSurname2(?string $surname2): \App\Entity\Student
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSurname2', [$surname2]);

        return parent::setSurname2($surname2);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmail(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmail', []);

        return parent::getEmail();
    }

    /**
     * {@inheritDoc}
     */
    public function setEmail(?string $email): \App\Entity\Student
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEmail', [$email]);

        return parent::setEmail($email);
    }

    /**
     * {@inheritDoc}
     */
    public function getPhone(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPhone', []);

        return parent::getPhone();
    }

    /**
     * {@inheritDoc}
     */
    public function setPhone(?string $phone): \App\Entity\Student
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPhone', [$phone]);

        return parent::setPhone($phone);
    }

    /**
     * {@inheritDoc}
     */
    public function getIdentification(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIdentification', []);

        return parent::getIdentification();
    }

    /**
     * {@inheritDoc}
     */
    public function setIdentification(?string $identification): \App\Entity\Student
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIdentification', [$identification]);

        return parent::setIdentification($identification);
    }

    /**
     * {@inheritDoc}
     */
    public function getAdmitted(): ?bool
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAdmitted', []);

        return parent::getAdmitted();
    }

    /**
     * {@inheritDoc}
     */
    public function setAdmitted(?bool $admitted): \App\Entity\Student
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAdmitted', [$admitted]);

        return parent::setAdmitted($admitted);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreateTime(): ?\DateTimeInterface
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreateTime', []);

        return parent::getCreateTime();
    }

    /**
     * {@inheritDoc}
     */
    public function setCreateTime(?\DateTimeInterface $createTime): \App\Entity\Student
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreateTime', [$createTime]);

        return parent::setCreateTime($createTime);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdateTime(): ?\DateTimeInterface
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdateTime', []);

        return parent::getUpdateTime();
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdateTime(?\DateTimeInterface $updateTime): \App\Entity\Student
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdateTime', [$updateTime]);

        return parent::setUpdateTime($updateTime);
    }

    /**
     * {@inheritDoc}
     */
    public function getUser(): ?\App\Entity\User
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUser', []);

        return parent::getUser();
    }

    /**
     * {@inheritDoc}
     */
    public function setUser(?\App\Entity\User $user): \App\Entity\Student
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUser', [$user]);

        return parent::setUser($user);
    }

}
