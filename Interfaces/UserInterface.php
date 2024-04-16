<?php
interface UserInterface {
    public function register(): void;
    public function captchaVerify(): void;
    public function login(): void;
    public function home(): void;
    public function createUserSession(object $user): void;
    public function logout(): void;
    public function registrationLink(string $email): bool;
    public function emailConfirmation(string $email): void;
}
?>