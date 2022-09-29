<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\ConfigRepository;
use App\Repository\UserRepository;
use App\Service\DataBaseManagement\DataBaseManagementFactory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpClient\CurlHttpClient;

class ApiUsersService
{
    public function __construct(
        ManagerRegistry             $registry,
        ConfigRepository            $configRepository,
        UserRepository              $userRepository,
        DataBaseManagementFactory   $db
    ) {
        $this->configRepo = $configRepository;
        $this->userRepo   = $userRepository;
        $this->db         = $db->initialize();

        $configEndPoint   = $this->configRepo->getVariable("USERS_API_ENDPOINT");
        $defaultEndPoint  = "https://reqres.in/api/";
        
        $this->endPoint   = (empty($configEndPoint)) ? $defaultEndPoint : $configEndPoint;
    }

    /**
     * Función para comprobar el login de un usuario mediante sus credenciales.
     *
     * @param   string  $email
     * @param   string  $password
     * 
     * @return  bool
     */
    private function checkLogin(string $email, string $password): bool 
    {
        $url  = $this->endPoint . "login";
        $curl = new CurlHttpClient();

        $fields = [
            "email"     => $email,
            "password"  => $password
        ];

        try {
            $response = $curl->request("POST", $url, ["body" => $fields]);
        } catch (\Throwable $th) {
            return false;
        }

        return ($response->getStatusCode() === 200) ? true : false;        
    }

    /**
     * Función para autenticar a un usuario mediante sus credenciales.
     *
     * @param   string  $email
     * @param   string  $password
     * 
     * @return  bool
     */
    public function authenticateUser(string $email, string $password): bool 
    {
        $checkResult = $this->checkLogin($email, $password);
        if (!$checkResult) {
            return false;
        }

        // Guardamos al usuario en la caché de usuarios (Entity User)
        try {
            $user = $this->userRepo->findOneByEmail($email);
            if (!$user) {
                $user = new User($email);
            }
            $this->db->save($user);
        
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return false;
        }

        return true;        
    }

    public function getUsers()
    {

    }
}