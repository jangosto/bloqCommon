<?php

namespace Bloq\Common\EntitiesBundle\Manager;

use FOS\UserBundle\Entity\UserManager as FOSUserManager;

class UserManager extends FOSUserManager
{
    public function getByIds(array $ids)
    {
        $contents = null;

        if(count($ids) > 0) {
            $conditionArray = array();

            foreach ($ids as $id) {
                $conditionArray[] .= "fos_user.id=".$id;
            }
            $whereQuery = " WHERE ".implode(" OR ", $conditionArray);

            $contents = $this->em->createQuery("SELECT fos_user FROM ".$this->class." fos_user".$whereQuery)->getResult();
        }

        if (null === $contents) {
            $contents = array();
        }

        return $contents;
    }
}
