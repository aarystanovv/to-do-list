<?php

require __DIR__ . '/vendor/autoload.php'; // Путь к файлу autoload.php из установленной библиотеки Google API PHP
include "includes/inc.connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['todoItem'])) {
    // Путь к файлу JSON с учетными данными
    echo 'Posted';
    $client = new Google_Client();
    $client->setAuthConfig('./credentials.json');
    echo 'Authorized';
    $client->addScope(Google_Service_Sheets::SPREADSHEETS);

    // Получите экземпляр Google Sheets
    $service = new Google_Service_Sheets($client);

    // ID вашей таблицы Google Sheets
    $spreadsheetId = '1ncA-PFzD2mvoG6sL06tkPjvkB2eiT5tK14kN9SQB5H0';

    // Получаем значение ID задачи из POST-запроса
    $taskId = $_POST['todoItem'];

    // Получаем данные задачи из базы данных по её ID
    $sql = "SELECT * FROM items WHERE id = $taskId";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $task = $row['todoItem'];

        // Данные о задаче
        $date = date('Y-m-d H:i:s'); // Текущая дата и время

        // Данные для добавления в таблицу
        $values = [
            [$date, $task],
        ];

        // Параметры запроса для добавления данных
        $requestBody = new Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);

        // Выполните запрос на добавление данных
        $response = $service->spreadsheets_values->append(
            $spreadsheetId,
            'A:B', // Диапазон ячеек для записи данных
            $requestBody,
            ['valueInputOption' => 'RAW']
        );

        // Проверка успешности выполнения запроса и вывод сообщения
        if ($response->getUpdates()->getUpdatedCells() > 0) {
            echo "Task successfully added to Google Sheets!";
        } else {
            echo "Error occurred while adding task to Google Sheets.";
        }
    } else {
        echo "Task not found or database error.";
    }
}
?>
