# Тестовое задание covid-test

В архиве маленький тестовый проект на yii basic.

Две модели - Пациенты и Поликлиники + Управление пользователями.

Внутри архива также есть дамп базы данных рабочий с небольшим набором тестовых данных.

Для управления правами и пользователями используется модуль https://github.com/webvimark/user-management

**В рамках тестовой задачи нужно разработать несколько методов API, которые могут быть использованы как внутри сервиса для запросов от фронтенда сервиса, так и внешними сервисами.**

### Общие требования к API
Формат данных ответа - JSON, структура на усмотрение исполнителя.

Все методы API должны работать от имени конкретного авторизованного пользователя с учетом его прав.

API должны поддерживать два метода авторизации:
- По ключу авторизации – строка, связанная с конкретным пользователем. Для того чтобы можно было совершать запросы из внешних сервисов с этим ключом.
- По стандартной куки авторизации. То есть если пользователь авторизован в сервисе, запросы совершаются из браузера и этого же домена (фронтенд сервиса), то никаких дополнительных данных кроме установленного при авторизации COOKIE в запросе передаваться не должно.

Оба описанных метода лишь дублируют текущий функционал проекта, поэтому результат должен максимально использовать текущий код проекта и одновременно не ломать текущий функционал проекта.

#### Метод API – список пациентов.
Запрос к API может содержать всевозможные фильтры со страницы /пациенты:

- Подстрока ФИО
- Подстрока телефона
- Поликлиника
- Статус
- Форма лечения
- Течения болезни
- Номер страницы

Ответ сервера должен содержать:
 - Список пациентов, только поля необходимые для вывода в таблице
 - Общее количество пациентов, удовлетворяющих условиям фильтра

#### Метод API – создание пациента
В параметрах передаются все поля аналогичные форме создания  /patientss/create

Ответ сервера должен содержать:
- Статус операции
- Если есть ошибки валидации, то список ошибок
- Если операция совершена успешно, то ID созданного пользователя

#### Требования к результату
В качестве результата выполнения задачи должны быть переданы:
- Архив с измененным кодом
- Кратко документация (методы, параметры, примеры запросов) в формате коллекции postman https://learning.postman.com/docs/getting-started/importing-and-exporting-data/ , который может быть импортирован и использован для тестов.

## Результат 

Разработан модуль - **modules/api**