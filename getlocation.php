<?php
$city = $_POST['city'] ?? '';

$locationMap = [
    // Maharashtra - Akola District
    'Akola' => ['state' => 'Maharashtra', 'pin' => '444001'],
    'Main Branch' => ['state' => 'Maharashtra', 'pin' => '444001'],
    'Tajnapeth' => ['state' => 'Maharashtra', 'pin' => '444002'],
    'Tapadia Nagar' => ['state' => 'Maharashtra', 'pin' => '444003'],
    'Gaurakshan Road' => ['state' => 'Maharashtra', 'pin' => '444004'],
    'Sindhi Camp' => ['state' => 'Maharashtra', 'pin' => '444005'],
    'Akot Road' => ['state' => 'Maharashtra', 'pin' => '444006'],
    'Malkapur Road' => ['state' => 'Maharashtra', 'pin' => '444007'],
    'Old City' => ['state' => 'Maharashtra', 'pin' => '444008'],
    'Murtizapur' => ['state' => 'Maharashtra', 'pin' => '444107'],
    'Telhara' => ['state' => 'Maharashtra', 'pin' => '444108'],

    // Maharashtra - Washim District
    'Washim' => ['state' => 'Maharashtra', 'pin' => '444505'],
    'Malegaon' => ['state' => 'Maharashtra', 'pin' => '444503'],
    'Risod' => ['state' => 'Maharashtra', 'pin' => '444506'],
    'Mangrulpir' => ['state' => 'Maharashtra', 'pin' => '444403'],
    'Shelubazar' => ['state' => 'Maharashtra', 'pin' => '444504'],
    'Karanja' => ['state' => 'Maharashtra', 'pin' => '444105'],
    'Shirpur' => ['state' => 'Maharashtra', 'pin' => '444402'],
    'Manora' => ['state' => 'Maharashtra', 'pin' => '444404'],

    // Maharashtra - Amravati District
    'Amravati' => ['state' => 'Maharashtra', 'pin' => '444601'],
    'Paratwada' => ['state' => 'Maharashtra', 'pin' => '444805'],
    'Chandur Railway' => ['state' => 'Maharashtra', 'pin' => '444904'],

    // Maharashtra - Buldhana District
    'Khamgaon' => ['state' => 'Maharashtra', 'pin' => '444303'],
    'Malkapur' => ['state' => 'Maharashtra', 'pin' => '443101'],
    'Lonar' => ['state' => 'Maharashtra', 'pin' => '443302'],

    // Maharashtra - Mumbai
    'Mumbai' => ['state' => 'Maharashtra', 'pin' => '400001'],
    'Kalbadevi' => ['state' => 'Maharashtra', 'pin' => '400002'],
    'Goregaon' => ['state' => 'Maharashtra', 'pin' => '400062'],

    // Madhya Pradesh - Khandwa District
    'Khandwa' => ['state' => 'Madhya Pradesh', 'pin' => '450001'],
    'Burhanpur' => ['state' => 'Madhya Pradesh', 'pin' => '450331'],

    // Madhya Pradesh - Indore District
    'Indore' => ['state' => 'Madhya Pradesh', 'pin' => '452001'],

     // Delhi
    'New Delhi' => ['state' => 'Delhi', 'pin' => '110001'],
    'Connaught Place' => ['state' => 'Delhi', 'pin' => '110001'],
    'Chandni Chowk' => ['state' => 'Delhi', 'pin' => '110006'],
    'Dwarka' => ['state' => 'Delhi', 'pin' => '110075'],
    
    // Uttar Pradesh
    'Lucknow' => ['state' => 'Uttar Pradesh', 'pin' => '226001'],
    'Varanasi' => ['state' => 'Uttar Pradesh', 'pin' => '221001'],
    'Kanpur' => ['state' => 'Uttar Pradesh', 'pin' => '208001'],
    'Agra' => ['state' => 'Uttar Pradesh', 'pin' => '282001'],
    
     // Gujarat
    'Ahmedabad' => ['state' => 'Gujarat', 'pin' => '380001'],
    'Surat' => ['state' => 'Gujarat', 'pin' => '395001'],
    'Vadodara' => ['state' => 'Gujarat', 'pin' => '390001'],
    
     // Tamil Nadu
    'Chennai' => ['state' => 'Tamil Nadu', 'pin' => '600001'],
    'Coimbatore' => ['state' => 'Tamil Nadu', 'pin' => '641001'],
    'Madurai' => ['state' => 'Tamil Nadu', 'pin' => '625001'],
    'Chidambaram' => ['state' => 'Tamil Nadu', 'pin' => '608001'],
    
    // Rajasthan
    'Jaipur' => ['state' => 'Rajasthan', 'pin' => '302001'],
    'Udaipur' => ['state' => 'Rajasthan', 'pin' => '313001'],
    'Jodhpur' => ['state' => 'Rajasthan', 'pin' => '342001'],
  
     // West Bengal
    'Kolkata' => ['state' => 'West Bengal', 'pin' => '700001'],
    'Howrah' => ['state' => 'West Bengal', 'pin' => '711101'],
    'Durgapur' => ['state' => 'West Bengal', 'pin' => '713201'],
    
     // Karnataka
    'Bengaluru' => ['state' => 'Karnataka', 'pin' => '560001'],
    'Mysuru' => ['state' => 'Karnataka', 'pin' => '570001'],
    'Hubli' => ['state' => 'Karnataka', 'pin' => '580020'],
    
    // Andhra Pradesh
    'Hyderabad' => ['state' => 'Andhra Pradesh', 'pin' => '500001'],
    'Vijayawada' => ['state' => 'Andhra Pradesh', 'pin' => '520001'],
    'Visakhapatnam' => ['state' => 'Andhra Pradesh', 'pin' => '530001'],
    
     // Kerala
    'Kochi' => ['state' => 'Kerala', 'pin' => '682001'],
    'Thiruvananthapuram' => ['state' => 'Kerala', 'pin' => '695001'],
    'Kozhikode' => ['state' => 'Kerala', 'pin' => '673001'],

];

$response = $locationMap[$city] ?? ['state' => '', 'pin' => ''];
echo json_encode($response);
?>
