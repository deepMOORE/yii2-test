# Yii2 Тестовый Проект

Простое приложение для управления библиотечным каталогом с системой отчетности.

## Ключевые ссылки

### Отчеты
- **Контроллер отчетов**: [`controllers/ReportController.php`](controllers/ReportController.php)
  - Отчет по топ авторам за год

### Управление книгами
- **Контроллер книг**: [`controllers/BookController.php`](controllers/BookController.php)
- **Сервис создания книг**: [`services/BookService.php`](services/BookService.php)
  - При создании книги диспатчится джоба `NewBookNotifyUsersJob` (строка 26-30)