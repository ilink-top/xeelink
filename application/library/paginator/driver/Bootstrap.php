<?php
namespace app\library\paginator\driver;

use think\paginator\driver\Bootstrap as Paginator;

class Bootstrap extends Paginator
{
    public function toArray()
    {
        try {
            $total = $this->total();
        } catch (\DomainException $e) {
            $total = null;
        }

        return [
            'total'        => $total,
            'per_page'     => $this->listRows(),
            'current_page' => $this->currentPage(),
            'last_page'    => $this->lastPage,
            'list'         => $this->items->toArray(),
        ];
    }
}
