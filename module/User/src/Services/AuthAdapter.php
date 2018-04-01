<?php
namespace User\Services;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use User\Models\User;
use User\Services\UserManager;

class AuthAdapter implements AdapterInterface
{
    public $_username;
    public $_password;
    public $_id;

    private $_userManager;
    private $_userPrivilegeTable;

    public function __construct(UserManager $userManager,UserPrivilegeTable $userPrivilegeTable)
    {
        $this->_userManager = $userManager;
        $this->_userPrivilegeTable = $userPrivilegeTable;
    }

    public function authenticate()
    {
        $user = $this->_userManager->findByUsername($this->_username);

        if ($user == null) {
            return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                null,
                ['Invalid credentials.']);
        }

        $sentPass = $this->_password;

        if ($user->_password == $sentPass) {
            return new Result(
                Result::SUCCESS,
                $this->_username,
                ['Authenticated successfully.']);
        }

        return new Result(
            Result::FAILURE_CREDENTIAL_INVALID,
            null,
            ['Invalid password.']);
    }

}