<?php

namespace App\Controllers;
use App\Models\User;

/**
 * Контроллер UserController
 */
class UserController
{
    /**
     * Action для страницы "Регистрация"
     */
    public function actionRegister():bool
    {
        $data = json_decode(file_get_contents('php://input'), true);
        // Переменные для формы
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];

        // Флаг ошибок
        $errors = [];

        // Валидация полей
        if (!User::checkName($name)) {
            $errors[] = 'Name: Имя не должно быть короче 2-х символов';
        }
        if (!User::checkEmail($email)) {
            $errors[] = 'Email: Неправильный формат email';
        }
        if (!User::checkPassword($password)) {
            $errors[] = 'Password: Пароль не должен быть короче 6-ти символов';
        }
        if (User::checkEmailExists($email)) {
            $errors[] = 'Email: Такой email уже используется';
        }

        if (!$errors) {
            // Если ошибок нет
            // Регистрируем пользователя
            User::create($name, $email, $password);
            // header("Location: /login");
        } else {
            echo json_encode($errors);
            return false;
        }
        // Подключаем вид
        echo "User successfully registered";
        return true;
    }

    /**
     * Action для страницы "Вход на сайт"
     */
    public function actionLogin():bool
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $email = $data['email'];
        $password = $data['password'];
        $errors = [];

        // Проверяем существует ли пользователь
        $userId = User::checkUserData($email, $password);

        if (!$userId) {
            // Если данные неправильные - показываем ошибку
            $errors[] = 'Неправильные данные для входа на сайт';
        }
        if ($errors) {
            echo json_encode($errors);
            return false;
        }
            // Если данные правильные, запоминаем пользователя (сессия)
            User::auth($userId);
            // header("Location: /home");

        return true;
    }

    /**
     * Удаляем данные о пользователе из сессии
     */
    public function actionLogout()
    {
        // Стартуем сессию
        session_start();

        // Удаляем информацию о пользователе из сессии
        unset($_SESSION["user"]);

        // Перенаправляем пользователя на главную страницу
        header("Location: /");
    }

}
