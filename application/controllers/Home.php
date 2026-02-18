<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0); // Handle preflight request
}

class Home extends CI_Controller 
{
  public function __construct()
  {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library(['form_validation', 'upload', 'session', 'pagination', 'encryption']);
        $this->load->database();
        $this->load->model('Site_Modal');
  }

  public function registeruser()
  {
        $postData = json_decode(file_get_contents("php://input"), true);
            if (
          !empty($postData['firstName']) &&
          !empty($postData['lastName']) &&
          !empty($postData['phoneNumber']) &&
          !empty($postData['email'])
        ) {
     
        $postData = json_decode(file_get_contents("php://input"), true);

        // Fixed columns in DB
        $fixedFields = ['firstName', 'lastName', 'email', 'phoneNumber'];

        $mainData = array_intersect_key($postData, array_flip($fixedFields));

        // Everything else = dynamic fields
        $extraData = array_diff_key($postData, array_flip($fixedFields));

        // Convert dynamic data to JSON
        $mainData['extra_fields'] = json_encode($extraData);
              $this->Site_Modal->addUserdetails($mainData);
              $data = ["status" => true, "successmsg" => "Data inserted successfully"];
                echo json_encode($data);
            }

          }

  public function showallrecords()
      {
        $result = $this->Site_Modal->showdata();
        print_r($result);
      }


    public function updateUser($userId)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($userId) && !empty($data)) {

            // Fields that exist as real DB columns
            $fixedFields = ['firstName', 'lastName', 'phoneNumber', 'email'];

            // Separate fixed data
            $updateData = array_intersect_key($data, array_flip($fixedFields));

            // Remaining fields = dynamic fields
            $extraData = array_diff_key($data, array_flip($fixedFields));

            // Convert dynamic fields to JSON before saving
            if (!empty($extraData)) {
                $updateData['extra_fields'] = json_encode($extraData);
            }
            $updated = $this->Site_Modal->updateUserById($userId, $updateData);
            echo json_encode([
                "status" => $updated,
                "message" => "Data Updated Successfully"
            ]);
        }
    }

    public function deleteUser()
        {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!empty($data['userId'])) {

                $deleted = $this->Site_Modal->deleteUserById($data['userId']);

                echo json_encode(["status" =>$deleted,  "message" => "User Deleted Successfully"]);
            }

        }
}

  