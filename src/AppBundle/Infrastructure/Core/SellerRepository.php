<?php

namespace AppBundle\Infrastructure\Core;

use AppBundle\Infrastructure;
use Domain\Core\Domain;
use \Domain\Core\Seller;

class SellerRepository extends EntityRepository implements \Domain\Core\SellerRepository
{

    private $entityPath = 'AppBundle\Infrastructure\Core\Seller';

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        $repository = $this->getRepository();
        return $repository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        $repository = $this->getRepository()
            ->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery();

        return $repository->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function byKeyName($keyName)
    {
        $repository = $this->getRepository();
        $seller = $repository->findOneByKeyName($keyName);

        return $seller;
    }

    public function byKeyNameAndToken($keyName, $token)
    {
        return $this->getRepository()
            ->findOneBy(['keyName' => $keyName, 'accessToken' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function add(Seller $seller)
    {
        $seller = SellerDataMapper::getInstance()->map($seller);
        $this->getEntityManager()->persist($seller);
        $this->getEntityManager()->flush($seller);
        return $seller;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityPath()
    {
        return $this->entityPath;
    }

}
