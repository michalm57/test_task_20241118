<!DOCTYPE html>
<html lang="pl">

    <head>
        <meta charset="utf-8" />
        <title>zadanie</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="zadanie" name="description" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <!-- JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>
        <div class="container">
            <div id="errors_container"></div>
            <form action="src/forms/zadanie_form.php" method="POST">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3>Formularz</h3>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group pb-4">
                                <label for="name">Imię</label>
                                <input type="text" id="name" name="name" maxlength="30" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group pb-4">
                                <label for="surname">Nazwisko</label>
                                <input type="text" id="surname" name="surname" maxlength="40" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group pb-4">
                                <label for="email">Adres e-mail</label>
                                <input type="email" id="email" name="email" maxlength="80" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group pb-4">
                                <label for="phone_optional">Numer telefonu komórkowego</label>
                                <input type="text" id="phone" name="phone" maxlength="9" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group pb-4">
                                <label for="code">Numer klienta</label>
                                <input type="text" id="client_no" name="client_no" maxlength="12" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group pb-4">
                                <label class="customcheck">
                                    <input type="radio" name="choose" value="1" required>
                                    Wybór 1
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <label class="customcheck">
                                    <input type="radio" name="choose" value="2" required>
                                    Wybór 2
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row hide">
                        <div class="col-md-12">
                            <div class="form-group pb-4">
                                <label for="account">Numer konta</label>
                                <input type="text" id="account" name="account" maxlength="36" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <label class="customcheck">
                                <input type="checkbox" id="agreement1" name="agreement1" required>
                                Oświadczenie 1
                            </label>
                        </div>
                        <div>
                            <label class="customcheck">
                                <input type="checkbox" id="agreement2" name="agreement2" required>
                                Oświadczenie 2
                            </label>
                        </div>
                        <div>
                            <label class="customcheck">
                                <input type="checkbox" id="agreement3" name="agreement3">
                                Zgoda 1 (opcjonalna)
                            </label>
                        </div>

                    </div>
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Wyślij</button>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12 text-center">
                    <hr />
                    <h3>Liczniki</h3>
                </div>
                <div class="col-md-6 text-center">
                    <b>Liczba rekordów dla nazwiska Kowalski</b>
                    <div>X</div>
                </div>
                <div class="col-md-6 text-center">
                    <b>Liczba rekordów dla emaila w domenie gmail.com</b>
                    <div>Y</div>
                </div>
            </div>
        </div>
    </body>
</html>