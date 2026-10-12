<?php
namespace App\Controllers;
use App\Models\CustomerAccountModel;

class Admin extends BaseController
{
    protected $accountModel;

    public function __construct()
    {
        $this->accountModel = new CustomerAccountModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('user_type') !== 'admin') {
            return redirect()->to('/login');
        }

        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');

        $query = $this->accountModel;

        if ($search) {
            $query = $query->groupStart()
                ->like('customer_name', $search)
                ->orLike('account_number', $search)
                ->orLike('email', $search)
                ->orLike('phone', $search)
                ->groupEnd();
        }

        if ($status) {
            $query = $query->where('status', $status);
        }

        $statsModel = new CustomerAccountModel();

        $data = [
            'accounts'           => $query->orderBy('created_at', 'DESC')->paginate(5),
            'pager'              => $this->accountModel->pager,
            'search_keyword'     => $search,
            'filter_status'      => $status,
            'total_accounts'     => $statsModel->countAllResults(),
            'active_accounts'    => $statsModel->where('status', 'active')->countAllResults(),
            'inactive_accounts'  => $statsModel->where('status', 'inactive')->countAllResults(),
            'suspended_accounts' => $statsModel->where('status', 'suspended')->countAllResults(),
        ];

        return view('admin/index', $data);
    }

    public function create()
    {
        if (!session()->get('isLoggedIn') || session()->get('user_type') !== 'admin') {
            return redirect()->to('/login');
        }
        return view('admin/create');
    }

    public function store()
    {
        if (!session()->get('isLoggedIn') || session()->get('user_type') !== 'admin') {
            return redirect()->to('/login');
        }

        $this->accountModel->save([
            'account_number'  => $this->request->getPost('account_number'),
            'customer_name'   => $this->request->getPost('customer_name'),
            'address'         => $this->request->getPost('address'),
            'phone'           => $this->request->getPost('phone'),
            'email'           => $this->request->getPost('email'),
            'meter_number'    => $this->request->getPost('meter_number'),
            'connection_type' => $this->request->getPost('connection_type'),
            'status'          => $this->request->getPost('status')
        ]);

        session()->setFlashdata('success', 'Customer account added successfully.');
        return redirect()->to('/admin');
    }

    public function edit($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('user_type') !== 'admin') {
            return redirect()->to('/login');
        }

        $data['account'] = $this->accountModel->find($id);
        return view('admin/edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('user_type') !== 'admin') {
            return redirect()->to('/login');
        }

        $this->accountModel->update($id, [
            'account_number'  => $this->request->getPost('account_number'),
            'customer_name'   => $this->request->getPost('customer_name'),
            'address'         => $this->request->getPost('address'),
            'phone'           => $this->request->getPost('phone'),
            'email'           => $this->request->getPost('email'),
            'meter_number'    => $this->request->getPost('meter_number'),
            'connection_type' => $this->request->getPost('connection_type'),
            'status'          => $this->request->getPost('status')
        ]);

        session()->setFlashdata('success', 'Customer account updated successfully.');
        return redirect()->to('/admin');
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('user_type') !== 'admin') {
            return redirect()->to('/login');
        }

        $this->accountModel->delete($id);
        session()->setFlashdata('success', 'Customer account deleted successfully.');
        return redirect()->to('/admin');
    }
}