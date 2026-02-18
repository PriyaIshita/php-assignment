
<?php 
class Site_Modal extends CI_Model 
{
	function addUserdetails($dataInsert)
	{
		//print_r('expression',$dataInsert);
		$this->db->insert('addusers',$dataInsert);
		return $this->db->affected_rows();

	}

	



function showdata()
	{ 
		$this->db->select('*');
		$this->db->from('addusers');
		$query=$this->db->get();
		//print_r($this->db->las//t_query());
		 $data=$query->result();
		 return json_encode($data);
	}



public function updateUserById($userId, $data)
    {
        $this->db->where('userId', $userId);
        return $this->db->update('addusers', $data);
    }

    public function deleteUserById($userId)
    {
        $this->db->where('userId', $userId);
        return $this->db->delete('addusers');
    }
}