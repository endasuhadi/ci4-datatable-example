<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		echo view('icd');
	}

	public function alist(){
		$request = Services::request();
		$m_icd = new Model_icd($request);
		print_r($m_icd->findAll(1));
	}

	public function ajax_list()
	{
		$request = Services::request();
		$m_icd = new Model_icd($request);
		if($request->getMethod(true)=='POST'){
			$lists = $m_icd->get_datatables();
	        $data = [];
	        $no = $request->getPost("start");
	        foreach ($lists as $list) {
	            	$no++;
	                $row = [];
	                $row[] = $no;
	                $row[] = $list->kode_icd;
	                $row[] = $list->nama_icd;
	                $data[] = $row;
			}

			$output = ["draw" => $request->getPost('draw'),
	                        "recordsTotal" => $m_icd->count_all(),
	                        "recordsFiltered" => $m_icd->count_filtered(),
	                        "data" => $data];
	        $output[csrf_token()] = csrf_hash();  
	        echo json_encode($output);
		}
	}

}
