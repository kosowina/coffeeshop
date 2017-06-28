<?php
namespace Menu\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class MenuTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getMenu($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveMenu(Menu $menu)
    {
        $data = [
            'name' => $menu->name,
            'description'  => $menu->description,
            'price' => $menu->price,
        ];

        $id = (int) $menu->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getMenu($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update menu with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteMenu($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
