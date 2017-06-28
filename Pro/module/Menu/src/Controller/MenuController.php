<?php
namespace Menu\Controller;

use Menu\Form\MenuForm;
use Menu\Model\Menu;
use Menu\Model\MenuTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MenuController extends AbstractActionController
{
    private $table;

    public function __construct(MenuTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'menus' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new MenuForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $menu = new Menu();
        $form->setInputFilter($menu->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $menu->exchangeArray($form->getData());
        $this->table->saveMenu($menu);
        return $this->redirect()->toRoute('menu');
    }

    public function editAction()
    {
      $id = (int) $this->params()->fromRoute('id', 0);

       if (0 === $id) {
           return $this->redirect()->toRoute('menu', ['action' => 'add']);
       }

       // Retrieve the menu with the specified id. Doing so raises
       // an exception if the menu is not found, which should result
       // in redirecting to the landing page.
       try {
           $menu = $this->table->getMenu($id);
       } catch (\Exception $e) {
           return $this->redirect()->toRoute('menu', ['action' => 'index']);
       }

       $form = new MenuForm();
       $form->bind($menu);
       $form->get('submit')->setAttribute('value', 'Edit');

       $request = $this->getRequest();
       $viewData = ['id' => $id, 'form' => $form];

       if (! $request->isPost()) {
           return $viewData;
       }

       $form->setInputFilter($menu->getInputFilter());
       $form->setData($request->getPost());

       if (! $form->isValid()) {
           return $viewData;
       }

       $this->table->saveMenu($menu);

       // Redirect to menu list
       return $this->redirect()->toRoute('menu', ['action' => 'index']);
    }

    public function deleteAction()
    {
      $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('menu');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteMenu($id);
            }

            // Redirect to list of menus
            return $this->redirect()->toRoute('menu');
        }

        return [
            'id'    => $id,
            'menu' => $this->table->getMenu($id),
        ];
    }
}
