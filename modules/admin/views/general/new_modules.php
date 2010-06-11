
<div class="notice">This is very important settings to install new modules in the application. Before procceding read the install document clearly! </div>
<div class="span-19">
<?php
                $msg=$this->input->get('msg');
                if($msg==1)
                {
                echo '<font color=red>Please set permission for application/config folder!</font>';
                }
                ?>
  <div  class="span-18 ">
    <table cellpadding="10" cellspacing="5">
      <tr>
        <th>Modules</th>
        
        <th>Action</th>
      </tr>
      <?php
      $project = trim($_SERVER['SCRIPT_NAME'],"index.php.");
	$dir = $this->file_docroot.$project."modules/";
	$dh = opendir($dir) or die("Cannot open the file $path");
	$file_get= array();
	$mod_get= array();	 
	while (($file = readdir($dh)) !== false)
	{ 
		if($file!='.' && $file!='..')
		{
		array_push($file_get, $file);
                }
                
        }
   
	foreach($this->module_setting as $row)
	{      
                array_push($mod_get, $row->name);
        }
              
             
        $tobein = array_diff($file_get,$mod_get);
        
        foreach ($tobein as &$value) 
        {
                echo "<tr><td>".$value."</td>";
                echo "<td><a href='".$this->docroot."admin/install/?mod=".$value."'>Install<a></td></tr>";
                
        }
        
       
              
        
           ?>
      </tr>
    
    </table>
  </div>
</div>
