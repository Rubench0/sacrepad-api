<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerNc7Iq45\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerNc7Iq45/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerNc7Iq45.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerNc7Iq45\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerNc7Iq45\srcApp_KernelDevDebugContainer(array(
    'container.build_hash' => 'Nc7Iq45',
    'container.build_id' => 'b03d66b6',
    'container.build_time' => 1548990749,
), __DIR__.\DIRECTORY_SEPARATOR.'ContainerNc7Iq45');
