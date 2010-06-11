<?php
	echo new View("answers/search_right");
?>
<?php
if(count($this->template->show_question)>0){
	echo new view("answers/manage_answer");
}
else{
	echo UI::noresults_();
}  

?>












