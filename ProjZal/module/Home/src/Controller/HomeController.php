<?php
namespace Home\Controller;

use Home\Form\HomeForm;
use Home\Model\Home;
use Home\Model\HomeTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class HomeController extends AbstractActionController
{
	private $table;
	
	public function __construct(HomeTable $table)
    {
        $this->table = $table;
    }
	
    public function indexAction()
    {
        return new ViewModel([
            'homes' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new HomeForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $home = new Home();
        $form->setInputFilter($home->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $home->exchangeArray($form->getData());
        $this->table->saveHome($home);
        return $this->redirect()->toRoute('home');
    }

     public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('home', ['action' => 'add']);
        }

        // Retrieve the home with the specified id. Doing so raises
        // an exception if the home is not found, which should result
        // in redirecting to the landing page.
        try {
            $home = $this->table->getHome($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('home', ['action' => 'index']);
        }

        $form = new HomeForm();
        $form->bind($home);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($home->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveHome($home);

        // Redirect to home list
        return $this->redirect()->toRoute('home', ['action' => 'index']);
    }

	public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('[home]');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteHome($id);
            }

            // Redirect to list of home
            return $this->redirect()->toRoute('home');
        }

        return [
            'id'    => $id,
            'home' => $this->table->getHome($id),
        ];
    }
}