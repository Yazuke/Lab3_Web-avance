<?php
namespace Application\Services;

/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class NavManager
{

    private $authService;
    private $urlHelper;
    private $userManager;
    private $userPrivilege;
    private $privilege;

    public function __construct($authService, $urlHelper, $userManager, $userPrivilege,$privilege)
    {
        $this->authService = $authService;
        $this->urlHelper = $urlHelper;
        $this->userManager = $userManager;
        $this->userPrivilege = $userPrivilege;
        $this->privilege = $privilege;
    }

    /**
     * This method returns menu items depending on whether user has logged in or not.
     */
    public function getMenuItems()
    {
        $url = $this->urlHelper;
        $items = [];

        // Display "Login" menu item for not authorized user only. On the other hand,
        // display "Admin" and "Logout" menu items only for authorized users.
        if (!$this->authService->hasIdentity()) {
            $items[] = [
                'id' => 'login',
                'label' => 'Sign in',
                'link'  => $url('login')
            ];
        } else {

            //Récupère id de l'utilisateur connecté
            $id=$this->userManager->findByUsername($this->authService->getIdentity())->_id;

            //Récupère l'id du privilege de l'utilisateur connecté
            $idPrivilege=$this->userPrivilege->findById($id)->_idPrivilege;

            //Récupère la valeur du privilege de l'utilisateur connecté
            $privilege=$this->privilege->findById($idPrivilege)->_value;

            $items[] = [
                'id' => 'logout',
                'label' => $this->authService->getIdentity()." [".$id."] [".$privilege."]",
                'dropdown' => [
                    [
                        'id' => 'logout',
                        'label' => 'Sign out',
                        'link' => $url('logout')
                    ],
                ]
            ];
            $items[] = [
                'id' => 'panier',
                'label' => 'panier',
                'link'=>$url('panier')
            ];
        }

        return $items;
    }
}