## Фикстуры

1. Накатывание общих фикстур для всего приложения в модулях напр. /src/Authentication/Fixture
2. Накатывание фикстур для каждого теста напр backend/tests/Functional/V1/Authentication/Join/Fixtures/RequestFixture.php
3. Очистка фикстуры после выполнения теста + накатывание общих фикстур

## Ansible

1. Создать в каталоге `ansible/inventory` фаил по типу `ansible/inventory.example`
2. Запустить `make ansible-main`