<?php 

	
/**
 * Class questionobject
 */


class questionobject {
	public $questionno;
	public $question;
	public $type;
	public $typeshort;
	public $answers;

	function __construct($post) //input an array, usually from a post
	{
		$this->questionno = $post['questionno'];
		$this->question = $post['question'];
		$this->type = $post['type'];
		$this->answers = $post['answers'];
		
		if ($this->type == "shortanswer")
		{
			$this->typeshort = "SA";
		}
		if ($this->type == "multichoice")
		{
			$this->typeshort = "MC";
		}
		
	}

	function show()
	{
		?>
		<form action=<?php echo htmlspecialchars('mytests_edit.php');?> method="post">
			<button type="submit" name="itemtoedit" value="<?php echo $this->questionno ?>" style='
				width:auto; 
				height:auto; 
				margin:0; 
				padding:0; 
				border: 0;
				background:none; 
				color:#666; 
				text-align:left; 
				-moz-border-radius: 0px;
				-webkit-border-radius: 0px;
				border-radius: 0px;
				-moz-box-shadow: 0;
				-webkit-box-shadow: 0;
				box-shadow: none;
				-webkit-appearance: none;
				text-transform: none;
				letter-spacing: 1px;'>
					<p style='font-weight:bold'>
					<?php echo $this->questionno . " " . $this->question ; ?>
					<span style='font-weight:normal'>
					(<?php echo $this->typeshort ?>)
					</span></p>
					<?php ;
					echo "<p style='font-weight:normal'>Answers: " ;
					$n = 1;
					foreach($this->answers as $answer) 
					{
			    	if ($n > 1)
			    	{
			    		echo ", ";
			    	}
			    	$n ++;
					echo $answer;
					}
					?>
			</button>
		</form>
		<br>
		<?php 
	}
}


?>