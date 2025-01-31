

<?php


// include tab startup
if(isset($_GET['boundaryID']))
{
	$boundaryID = $_GET['boundaryID'];
}
$quizID = $_GET['quizID'];

$quizInfo = qtl_queries::getQuizInfo($quizID);
$quizName = qtl_utils::convertTextFromDB($quizInfo['quizName']);


$minGrade = '';
$maxGrade = '';
$feedback = '';
if($boundaryID<>"new")
{
	$boundaryInfo = qtl_queries::getBoundaryInfo($boundaryID);
	$minGrade= $boundaryInfo['minGrade'];
	$maxGrade= $boundaryInfo['maxGrade'];
	$feedback = qtl_utils::convertTextFromDB($boundaryInfo['feedback']);
}

// get the grade boundaries as array
$myBoundaries = qtl_queries::getGradeBoundaries($quizID);

$minAllowedScore = $_GET['min'];
$maxAllowedScore = $_GET['max'];

?>
<h2>Edit Boundary</h2>
<a href="?page=ai-quiz-boundaries&quizID=<?php echo $quizID; ?>" class="backIcon">Return to my boundaries</a><br/><br/>

<form action="?page=ai-quiz-boundaries&quizID=<?php echo $quizID ?>&action=boundaryEdit" method="post">
<?php

$thisMinAllowedScore = $minAllowedScore;

echo '<select id="minGrade" name="minGrade">';
while($thisMinAllowedScore<=$maxAllowedScore)
{
	echo '<option value="'.$thisMinAllowedScore.'"';
	if($minGrade==$thisMinAllowedScore){echo ' selected';}
	echo '>'.$thisMinAllowedScore;
	echo '</option>';
	$thisMinAllowedScore++;
}
echo '</select>';
echo '<label for="minGrade">Minimum Score</label>';

echo '<hr/>';

$thisMinAllowedScore = $minAllowedScore;

if($boundaryID=="new")
{
	$maxGrade = $maxAllowedScore; // set the default max allowed to the max score
}

echo '<select id="maxGrade" name="maxGrade">';
while($thisMinAllowedScore<=$maxAllowedScore)
{
	echo '<option value="'.$thisMinAllowedScore.'"';
	if($maxGrade==$thisMinAllowedScore){echo ' selected';}
	echo '>'.$thisMinAllowedScore;
	echo '</option>';
	$thisMinAllowedScore++;
}
echo '</select>';
echo '<label for="maxGrade">Maximum Score</label>';
echo '<hr/>';

echo '<b>Feedback to display</b><br/>';
wp_editor($feedback, 'feedback', '', true);

echo '<input type="hidden" value="'.$quizID.'" name="quizID">';
echo '<input type="hidden" value="'.$boundaryID.'" name="boundaryID">';

?>
<input type="submit" value="Update" class="button-primary"/>

</form>
