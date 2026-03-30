<?php
//
//use Psr\Container\ContainerInterface;
//
///**
// * An inversion of control container.
// */
//class IoCContainer implements ContainerInterface {
//
//    public function get(string $id)
//    {
//        // TODO: Implement get() method.
//        // 1. Throw Psr\Container\NotFoundExceptionInterface if id does not exist in container
//        if ($this->has($id)) {
//            throw new Exception("Service '$id' not found");
//        }
//        try {
//            // 2. Get configuration for id
//            $config = $this->getConfig($id);
//            // 3. Create factory callback for service based on id
//            $factory
//        // 4. Cache service if it is a singleton
//        // 5. Otherwise call factory
//        // 6. Throw Psr\Container\ContainerExceptionInterface if an error occurs while creating service
//        }catch (\Exception $exception){
//            throw new ContainerException
//        }
//    }
//
//    public function has(string $id): bool
//    {
//        // TODO: Implement has() method.
//    }
//
//    private function getConfig(string $id)
//    {
//    }
//}