<form enctype='multipart/form-data' action='upload.php' method='post'>
	- tag -<br />
	<input type='text' name='tag'><br /><br />

	- 라이센스 -<br />
	<select name='license'>
		<option value="1">Attribution (저작자 표시)
		<option value="2">Noncommercial (비영리)
		<option value="3">No Derivative Works (변경금지)
		<option value="4">Share Alike (동일조건변경허락)
	</select><br /><br />

	- uploader -<br />
	<input type='text' name='uploader'><br /><br />

	- file -<br />
	<input type='file' name='uploadfile'>
	<button>upload</button>
</form>