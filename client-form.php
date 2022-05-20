<?php include_once './template-header.php'; ?>
<?php
$key = (isset($_GET['key'])) ? \Library\System::_var($_GET['key']) : false;
$id = '';
$name = '';
$userName = '';
$zipCode = '';
$email = '';
$password = '';

if ($key) {
    $clientDao = new \Application\Dao\ClientDao();
    $client = $clientDao->loadById($key);
    $id = $client->getId();
    $name = $client->getName();
    $userName = $client->getUserName();
    $zipCode = $client->getZipCode();
    $email = $client->getEmail();
    $password = $client->getPassword();
}
?>
<main>
    <div class="box">
        <h1>Cadastro de Cliente</h1>
        <div class="formBox">
            <form action="client-func.php?action=save" method="post" class="defaultForm" id="clienteForm">
                <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                <div class="row">
                    <label for="name">Nome Completo:</label><br />
                    <input type="text" id="name" required="required" name="name" value="<?php echo $name; ?>" class="input input50" />
                </div>
                <div class="row">
                    <label for="userName">Nome de Login:</label><br />
                    <input type="text" id="userName" required="required" name="userName" value="<?php echo $userName; ?>" class="input input50" />
                </div>
                <div class="row">
                    <label for="zipCode">CEP:</label><br />
                    <input type="text" id="zipCode" name="zipCode" required="required" value="<?php echo $zipCode; ?>" class="input input20" />
                </div>
                <div class="row">
                    <label for="email">Email:</label><br />
                    <input type="email" id="email" name="email" required="required" value="<?php echo $email; ?>" class="input input50" />
                </div>
                <div class="row">
                    <label for="password">Senha (8 caracteres mínimo, contendo pelo menos 1 letra e 1 número):</label><br />
                    <input type="password" id="password" name="password" required="required" value="<?php echo $password; ?>" class="input input20" oninput="password_validate(this)" />
                    <div id='result'></div>
                </div>
                <input type="submit" class="iBtn" value="Enviar" />
                <input type="button" onclick="location.href='client-list.php';" class="iBtnRed" value="Voltar" />
            </form>
        </div>
    </div>
</main>
<script>
    $("#zipCode").mask("99999-999");
    // Initialize complexify

    let validPassword = false;
    function password_validate(passwd) {
        validPassword = false;
        var color, result;
        if (passwd.value.length <= 0) {
            color = "transparent";
            result = "";
        }
        
        var fletter = /[a-z]/;
        var cap_lett = /[A-Z]/;
        var special_char = /[-!@#$%^&*()_+|~=`{}\[\]:";'<>?,.\/]/;
        var num = /[0-9]/;
        var white = /\s/;

        console.log(passwd.value);
        if (passwd.value.length < 8 & passwd.value.length > 0) {
            passwd.style.borderColor = "red";
            color = "red";
            result = "A senha precisa ter pelo menos 8 caracteres";
        } else if(!fletter.test(passwd.value)) {
            //macth uppercase character
            passwd.style.borderColor = "red";
            color = "red";
            result = "A senha precisa ter pelo 1 caracter minúsculo";
        } else if (!special_char.test(passwd.value)) {
            passwd.style.borderColor = "red";
            color = "red";
            result = "A senha precisa ter pelo 1 caracter especial";
        } else if (!cap_lett.test(passwd.value)) {
            /*capital_letter*/
            passwd.style.borderColor = "red";
            color = "red";
            result = "A senha precisa ter pelo 1 caracter maiúsculo";
        } else if (!num.test(passwd.value)) {
            /*one numeric*/
            passwd.style.borderColor = "red";
            color = "red";
            result = "A senha precisa ter pelo 1 numero";
        } else if (white.test(passwd.value)) {
            /*one numeric*/
            passwd.style.borderColor = "red";
            color = "red";
            result = "A senha não pode ter caractere vazio";
        } else {
            passwd.style.borderColor = "black";
            result = '';
            validPassword = true;
        }
        document.getElementById("result").innerHTML = result;
        document.getElementById("result").style.color = color;
    }

    $("#clienteForm").submit(function(event) {
        password_validate(document.getElementById("password"));
        if (!validPassword) {
            event.preventDefault();
        }
    });
</script>
<?php include_once './template-footer.php'; ?>