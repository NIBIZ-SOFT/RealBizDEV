<?php
function loadProjectData() {
    $projects = SQL_Select("boq");
    $projectTbleBody = "";

    if (!empty($projects)) {
        foreach ($projects as $project) {
            $projectTbleBody .= "
            <tr>
                <td>{$project['ProjectName']}</td>
                <td>{$project['BOQTitle']}</td>
                <td>{$project['DateInserted']}</td>
                <td>
                    <a href='./index.php?Theme=default&Base=BOQ&Script=editProject&NoHeader&NoFooter?BoqID={$project['BoqID']}' id='edit' class='btn btn-warning'>Edffit</a>
                    <a href='#' data-project_id='{$project['BoqID']}' id='copy' class='btn btn-info copyProject'>Copy</a>
                    <a href='#' data-project_id='{$project['BoqID']}' id='delete' class='btn btn-info deleteProject'>Delete</a>
                </td>
            </tr>
            ";
        }
    } else {
        $projectTbleBody = "<tr><td colspan='4'>No projects found.</td></tr>";
    }

    return $projectTbleBody;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');

    $data = [
        'success' => true,
        'loadedHTML' => loadProjectData()
    ];

    echo json_encode($data);
}
?>
