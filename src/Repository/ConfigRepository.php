<?php

namespace App\Repository;

use App\Entity\Config;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Config>
 *
 * @method Config|null find($id, $lockMode = null, $lockVersion = null)
 * @method Config|null findOneBy(array $criteria, array $orderBy = null)
 * @method Config[]    findAll()
 * @method Config[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfigRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, Config::class);
    }

    /**
     * Obtiene el dato de una variable de configuración.
     *
     * @param   string  $name   Nombre de la variable de configuración
     * 
     * @return  mixed   $value  Valor de la variable
     */
    public function getVariable(string $name): mixed 
    {
        $variable = $this->createQueryBuilder('c')
           ->andWhere('c.name = :name')
           ->setParameter('name', $name)
           ->getQuery()
           ->getOneOrNullResult()
        ;

        if (is_null($variable)) {
            return null;
        }
            
        switch ($variable->getType()) {
            case 'int':
            case 'integer':
                $value = intval($variable->getValue());
                break;
            
            case 'float':
                $value = floatval($variable->getValue());
                break;
            
            case 'bool':
            case 'boolean':
                $value = filter_var($variable->getValue(), FILTER_VALIDATE_BOOL);
                break;
            
            default:
                $value = $variable->getValue();
                break;
        }

        return $value;
    }

    /**
     * Obtiene el tipo de una variable de configuración.
     *
     * @param   string  $name   Nombre de la variable de configuración
     * 
     * @return  ?string Tipo de la variable
     */
    public function getVariableType(string $name): ?string 
    {
        $variable = $this->createQueryBuilder('c')
           ->andWhere('c.name = :name')
           ->setParameter('name', $name)
           ->getQuery()
           ->getOneOrNullResult()
        ;

        if (is_null($variable)) {
            return null;
        }

        return $variable->getType();
    }

    /**
     * Obtiene la descripción de una variable de configuración.
     *
     * @param   string  $name   Nombre de la variable de configuración
     * 
     * @return  ?string Descripción de la variable
     */
    public function getVariableDescription(string $name): ?string 
    {
        $variable = $this->createQueryBuilder('c')
           ->andWhere('c.name = :name')
           ->setParameter('name', $name)
           ->getQuery()
           ->getOneOrNullResult()
        ;

        if (is_null($variable)) {
            return null;
        }

        return $variable->getDescription();
    }

}
