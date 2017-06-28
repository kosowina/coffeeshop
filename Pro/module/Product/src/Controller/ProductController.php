<?php
namespace Product\Controller;

use Product\Form\ProductForm;
use Product\Model\Product;
use Product\Model\ProductTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProductController extends AbstractActionController
{
    private $table;

    public function __construct(ProductTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'products' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new ProductForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $product = new Product();
        $form->setInputFilter($product->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $product->exchangeArray($form->getData());
        $this->table->saveProduct($product);
        return $this->redirect()->toRoute('product');
    }

    public function editAction()
    {
      $id = (int) $this->params()->fromRoute('id', 0);

       if (0 === $id) {
           return $this->redirect()->toRoute('product', ['action' => 'add']);
       }

       // Retrieve the product with the specified id. Doing so raises
       // an exception if the product is not found, which should result
       // in redirecting to the landing page.
       try {
           $product = $this->table->getProduct($id);
       } catch (\Exception $e) {
           return $this->redirect()->toRoute('product', ['action' => 'index']);
       }

       $form = new ProductForm();
       $form->bind($product);
       $form->get('submit')->setAttribute('value', 'Edit');

       $request = $this->getRequest();
       $viewData = ['id' => $id, 'form' => $form];

       if (! $request->isPost()) {
           return $viewData;
       }

       $form->setInputFilter($product->getInputFilter());
       $form->setData($request->getPost());

       if (! $form->isValid()) {
           return $viewData;
       }

       $this->table->saveProduct($product);

       // Redirect to product list
       return $this->redirect()->toRoute('product', ['action' => 'index']);
    }

    public function deleteAction()
    {
      $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('product');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteProduct($id);
            }

            // Redirect to list of products
            return $this->redirect()->toRoute('product');
        }

        return [
            'id'    => $id,
            'product' => $this->table->getProduct($id),
        ];
    }
}
