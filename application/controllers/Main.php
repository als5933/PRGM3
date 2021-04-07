<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Main extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
 
        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */ 
 
        $this->load->library('grocery_CRUD');
 
    }
 
    public function index()
    {
        echo "<h1>Welcome to the world of Codeigniter</h1>";//Just an example to ensure that we get into the function
                die();
    }
 
    public function employees()
    {
        $crud = new grocery_CRUD();
		$crud->set_subject('Employee');       
	    $crud->set_table('employees');
		$crud->columns('lastName','firstName','email','jobTitle'); 
		$crud->fields('firstName','lastName','extension','email','jobTitle','officeCode','file_url');
		$crud->display_as('lastName','Last Name');
		$crud->display_as('firstName','First Name');
		 $crud->display_as('jobTitle','Job Title');
		 $crud->display_as('officeCode','Office Code');
		 $crud->required_fields('lastName','firstName','extension','email','jobTitle','officeCode');
		 $crud->set_rules('lastName','Last Name','htmlspecialchars|required|min_length[2]|max_length[30]');
		$crud->set_rules('firstName','First Name','htmlspecialchars|required|min_length[2]|max_length[30]');
        $crud->field_type('officeCode','dropdown',
		array('1' => '1', '2' => '2','3' => '3' , '4' => '4', '5' => '5', '6' => '6', '7' => '7'));

		//$crud->where('email','dmurphy@classicmodelcars.com');
		$output = $crud->render();
		$output->title="Employees";
        $this->_example_output($output);        
    }
	public function customers()
    {
        $crud = new grocery_CRUD();
		$crud->set_subject('Customer');
        $crud->set_table('customers');
		$crud->columns('custName','custEmail', 'custPassword'); 
		$crud->fields('custName','custEmail','custPassword');
		$crud->display_as('custName','Customer Name');
		$crud->display_as('custEmail','Customer Email');
		$crud->display_as('custPassword','Customer Password');
		$crud->required_fields('custName','custEmail', 'custPassword');
		$crud->set_rules('custName','Customer Name','htmlspecialchars|required|min_length[2]|max_length[30]');
		$crud->set_rules('custPassword','Customer Password','htmlspecialchars|required|min_length[8]|max_length[30]');
		 $crud->field_type('custPassword', 'password');

		$crud->callback_before_insert(array($this,'encrypt_pw'));
		
		//$crud->unset_add();

		//$crud->unset_edit();

		
		$output = $crud->render();
		$output->title="Customers";
        $this->_example_output($output);
		
	}
		
   function encrypt_pw($post_array) {
			    if(!empty($post_array['custPassword'])) {
					    $post_array['custPassword'] = SHA1($_POST['custPassword']);
			    }//if
			    return $post_array;
	    }//function
 
	
	

 
    function _example_output($output = null)
 
    {
        $this->load->view('our_template.php',$output);    
    }
}
 
/* End of file Main.php */
/* Location: ./application/controllers/Main.php */