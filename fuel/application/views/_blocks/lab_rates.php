<?php

    $labs = array(
        array('abbreviation' => 'microfab', 'full_name' => 'Fabrication Lab' ),
        array('abbreviation' => 'surface', 'full_name' => 'Micron Microscopy Core' ),
    );

    $buffer = "";
    foreach ($labs as $lab ) {
        $abbr = $lab['abbreviation'];
        $name = $lab['full_name'];
        
        $buffer .= "<h2>$name</h2>\n";
        $buffer .= "<table border=\"0\" class=\"pretty_table\">";
        $header = "<tr><th>Fee</th><th>University of Utah</th><th>External</th></tr>\n";
        $buffer .= $header;
        $row_class = "";

        $this->db->where( 'lab', $abbr);
        $this->db->where( 'active', '1');
        $rows = $this->db->get('lab_rates')->result_array();
        foreach($rows as $row)
        {
                $row_class = ($row_class == "odd" ? "even" : "odd");
                $internal = "\$" . $row['internal_amount'] . "/" . $row['per_units'];
                $external = "\$" . $row['external_amount'] . "/" . $row['per_units'];
                if ($row['external_amount'] == -1) {
                        $external = "N/A";
                }
                $buffer .= "<tr class=\"$row_class\">
                                <td>{$row['name']}</td>
                                <td>$internal</td>
                                <td>$external</td>
                        </tr>\n";
        }
        $buffer .= "</table>";
        
    }
    echo $buffer;

?>
