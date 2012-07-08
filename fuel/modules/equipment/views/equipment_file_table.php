<?
$eq = $equipment;
$folders = $eq->folders();
$file_uploaders = array();
echo "<div id=\"files\">\n";

if (isset($folders) && $folders) {
	//empty set?
	$isempty = (empty($folders['public']) &&
				empty($folders['member']) &&
				empty($folders['staff']) );


	if (!$isempty) {
		echo "<table>\n";
		echo "<tr><th>Name</th><th>Replace</th><th>Delete</th><th>Access</th><th></th></tr>\n";
		$file_number = 0;
		foreach ($folders as $folder => $contents) {
			if ($contents) {	
				
				foreach ($contents as $section) {
					echo "<tr><td colspan=\"4\"><h4>{$section['category']}</h4></td></tr>\n";
					foreach ($section['files'] as $file_label => $file_name) {
						$unique_id =  $file_number++;
						$path = urlencode($equipment->name) . '/' . $folder . '/' . urlencode($section['category']) . '/' . urlencode($file_label) . '/' . urlencode($file_name) ;
						echo "<tr>\n";
						echo "<td>" . "<a href=\"" . site_url('equipment/download_file/' . $path) . "\">$file_label</a></td>\n";
						echo "<td><a onclick=\"return open_upload_form('" . str_replace('/', "','",  $path)  . "'); \" href=\"\" class=\"update-svn\">Update</a></td>\n";
						echo "<td><a href=\"javascript:delete_file('" . site_url('equipment/delete_file/' . $path ) . "');\" class=\"delete-svn\">Delete</a></td>\n";
						echo "<td>$folder</td>\n";
						echo "<td><div id=\"progress-$unique_id\" style=\"background: #fff;\">&nbsp;</div></td>\n";
						echo "</tr>\n";
						$file_uploaders[] = array('unique_id' => $unique_id, 
											'path' => $path,
											'file_label' => $file_label,
											'category' => $section['category'],
											'access' => $folder,
											);
					}
				}
			}
		}	
		echo "</table>\n";
	}
}
	?>
<script>
		function progress_bar(element, loaded, total) {
			element.css( 'opacity', '1');
			element.css( 'background', '#0c0');
			element.css('width', '' + (loaded * 100 / total) + 'px');
			if (loaded > total) {
				loaded = total;
			}
			element.html('Uploading ' + Math.floor(loaded / 1024) + 'KB of ' + Math.floor(total / 1024) + 'KB' );
		}
		function show_upload_error(element, error) {
			element.css( 'background', '#c00');
			element.html('Error: ' + JSON.stringify(error));
		}
		function delete_file(url) {
			$('#files').load(url);
		}
</script>

</div>
