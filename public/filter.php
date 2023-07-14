<?php

require_once('./db/conn.php');

$value = filter_input(INPUT_GET, 'value', FILTER_DEFAULT);
$search = "%" . $value . "%";
$queryFilter = "SELECT id, name, profile, image FROM users WHERE name LIKE :value LIMIT 40";
$querySelectAll = "SELECT id, name, profile, image FROM users LIMIT 40";

if ($value) {
    $result = hopeStoriesFilter($conn, $queryFilter, $search);
    echo json_encode($result);
} else {
    $result = getAllHopeStories($conn, $querySelectAll, $search);
    echo json_encode($result);
}


function hopeStoriesFilter($conn, $query, $search)
{
    $result = $conn->prepare($query);
    $result->bindParam(':value', $search);
    $result->execute();

    if ($result and $result->rowCount() != 0) {
        $data = getUsers($result);
        $return = ['data' => $data];
        return $return;
    } else {
        $return = ['data' => []];
        return $return;
    }
};

function getAllHopeStories($conn, $query)
{
    $result = $conn->prepare($query);
    $result->execute();
    $data = getUsers($result);
    $return = ['data' => $data];
    return $return;
}

function getUsers($result)
{
    while ($user = $result->fetch(PDO::FETCH_ASSOC)) {
        $data[] = [
            "id" => $user["id"],
            "name" => $user["name"],
            "profile" => $user["profile"],
            "image" => $user["image"],
        ];
    };
    return $data;
}
