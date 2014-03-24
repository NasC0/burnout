<script>
    $(document).ready(function () {
        var errorClassForLabel = 'errorForLabel';
        $("#wizard")
            .on("stephide", "fieldset", function () {
                if (!$(this).find(":input").valid()) {
                    return false;
                }
            })
            .jWizard({
                buttons: {
                    cancel: false,
                    prev: {
                        text: "Назад"
                    },
                    next: {
                        text: "Напред"
                    },
                    finish: {
                        text: "Предай",
                        type: "submit"
                    }
                }
            })
            .validate({
                onclick: false,
                errorPlacement: function (error, element) {
                    alert('Моля, попълните всички полета преди да продължите!');
                    element.addClass();
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass(errorClass).removeClass(validClass);
                    $(element.form).find('[name=' + element.name + ']').each(function (i, sameName) {
                        $(element.form).find("label[for=" + sameName.id + "]").addClass(errorClassForLabel);
                    });
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass(errorClass).addClass(validClass);
                    $(element.form).find('[name=' + element.name + ']').each(function (i, sameName) {
                        $(element.form).find("label[for=" + sameName.id + "]").removeClass(errorClassForLabel);
                    });
                },
                submitHandler: function (form) {
                    alert("Благодарим ви,че участвахте в нашата анкета!");
                    form.submit();
                }
            });
        $('#Demographic3').keyup().blur(function () {
            var val = parseInt($(this).val());
            var msg = 'Моля въведете валидна възраст (с цифри).';
            if (isNaN(val) || 16 > val || val > 100) {

                var age = prompt(msg);
                while (isNaN(age) || 16 > age || age > 100) {
                    age = prompt(msg);
                }
                document.getElementById('Demographic3').value = age;
            }
        });
    });
</script>

<div class="scale-helper">
    <div class="scale-helper-div">
        <span class="scale-helper-span">Определено грешно</span>
        <span class="scale-helper-span">1</span>
    </div>
    <div class="scale-helper-div">
        <span class="scale-helper-span">Обикновено грешно </span>
        <span class="scale-helper-span">2</span>
    </div>
    <div class="scale-helper-div">
        <span class="scale-helper-span">Нито вярно, нито грешно</span>
        <span class="scale-helper-span">3</span>
    </div>
    <div class="scale-helper-div">
        <span class="scale-helper-span">Обикновено вярно</span>
        <span class="scale-helper-span">4</span>
    </div>
    <div class="scale-helper-div">
        <span class="scale-helper-span">Определено вярно</span>
        <span class="scale-helper-span">5</span>
    </div>
</div>

<form method="POST" name="burnoutForm" id="wizard">

<?php
$countFieldest = 1;
$labelCOunt = 1;
foreach ($content['questions'] as $questionKey => $questionVal) {
if ($countFieldest == 1) {

?>

<fieldset>
    <div class="header-wrap">
        <p>
            На следващите страници, ще срещнете твърдения, с които човек би могъл да опише своето отношение, мнение,
            интереси или чувства. Опитайте се да дадете отговори, които описват начина, по който обикновено се държите
            или чувствате, а не това какво изпитвате в този момент.
        </p>

        <p>
            Моля не прескачайте твърдения, отговорете, на всяко едно от тях. Няма грешен или верен отговор. Изберете
            само един отговор за всяко твърдение като използвате предложената скала.
        </p>
    </div>
    <?php
    $countFieldest += 4;
    }
    elseif ($countFieldest == 245) {
    ?>
</fieldset>
<fieldset>
    <div class="header-wrap">
        <p>
            Следващите твърдения се отнасят за характеристики и отношения в работата Ви и организацията, за която
            работите.
            Моля отговорете на всеки въпрос, като посочите доколко сте съгласни, че тези твърдения се отнасят до Вас и
            Вашата работа най-общо, а не само в конкретния момент.
        </p>

        <p>
            Няма правилни и грешни отговори – не отделяйте много време за да се замисляте – опишете собствените си
            мнения и чувства.
        </p>
    </div>
    <?php
    $countFieldest = 5;
    }
    elseif ($countFieldest % 25 == 0) {

    ?>

</fieldset>
<fieldset>

<?php
}

?>
<fieldset class="field-wrapper">
    <div class="inside-field-wrap-first">
                        <span>
                           <?= $questionKey ?>. <?= $questionVal ?>
                        </span>
    </div>
    <div class="inside-field-wrap-second">
        <?php
        foreach ($content['answers'] as $answerKey => $answerVal) {

            ?>
            <div class="inside-field-wrap-third">
                <input type="radio" id="<?= 'Radio' . $labelCOunt ?>" required name="<?= 'Q' . $questionKey ?>"
                       value="<?= $answerKey ?>">
                <label for="<?= 'Radio' . $labelCOunt ?>">
                    <?= $answerKey ?> </label>
            </div>
            <?php
            $labelCOunt++;
        }
        echo '</div></fieldset>';
        $countFieldest++;
        }


        ?>
</fieldset>
<fieldset>
<fieldset class="field-wrapper">
    <div class="inside-demographic-wrap-first">
        <span><?= $content['demographicKeys'][0]; ?>. <?= $content['demographic'][1] ?></span>
    </div>
    <div class="inside-demographic-wrap-second">
        <div class="demographic-third">
            <input type="radio" id="Demographic1" name="D1" value="1" required>
            <label for="Demographic1">Мъж</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic2" name="D1" value="2" required>
            <label for="Demographic2">Жена</label>
        </div>
    </div>
</fieldset>

<fieldset class="field-wrapper">
    <div class="inside-demographic-wrap-first">
        <span><?= $content['demographicKeys'][1]; ?>. <?= $content['demographic'][2] ?></span>
    </div>
    <div class="inside-demographic-wrap-second">
        <label for="Demographic3">Възраст: </label>
        <input type="text" id="Demographic3" name="D2" required>
    </div>
</fieldset>

<fieldset class="field-wrapper">
    <div class="inside-demographic-wrap-first">
        <span><?= $content['demographicKeys'][2]; ?>. <?= $content['demographic'][3] ?></span>
    </div>
    <div class="inside-demographic-wrap-second">
        <div class="demographic-third">
            <input type="radio" id="Demographic4" name="D3" value="1" required>
            <label for="Demographic4">Един</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic5" name="D3" value="2" required>
            <label for="Demographic5">Двама</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic6" name="D3" value="3" required>
            <label for="Demographic6">Трима</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic7" name="D3" value="4" required>
            <label for="Demographic7">Четирима</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic8" name="D3" value="5" required>
            <label for="Demographic8">Пет</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic9" name="D3" value="6" required>
            <label for="Demographic9">Шест или повече</label>
        </div>
    </div>
</fieldset>

<fieldset class="field-wrapper">
    <div class="inside-demographic-wrap-first">
        <span><?= $content['demographicKeys'][3]; ?>. <?= $content['demographic'][4] ?></span>
    </div>
    <div class="inside-demographic-wrap-second">
        <div class="demographic-third">
            <input type="radio" id="Demographic10" name="D4" value="1" required>
            <label for="Demographic10">Живея сам</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic11" name="D4" value="2" required>
            <label for="Demographic11">Живея с партньор/ка, без деца и без други роднини</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic12" name="D4" value="3" required>
            <label for="Demographic12">Родител с дете/деца, без други роднини</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic13" name="D4" value="4" required>
            <label for="Demographic13">Двама родители и дете/деца, без други роднини</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic14" name="D4" value="5" required>
            <label for="Demographic14">С партньор/ка и по-възрастни роднини</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic15" name="D4" value="6" required>
            <label for="Demographic15">Един родител с дете/деца и по-възрастен роднина/ни</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic16" name="D4" value="7" required>
            <label for="Demographic16">Двама родители с дете/деца и по-възрастен роднина/ни</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic17" name="D4" value="8" required>
            <label for="Demographic17">Състуденти, колеги в общо жилище</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic18" name="D4" value="9" required>
            <label for="Demographic18">Друго</label>
        </div>
    </div>
</fieldset>

<fieldset class="field-wrapper">
    <div class="inside-demographic-wrap-first">
        <span><?= $content['demographicKeys'][4]; ?>. <?= $content['demographic'][5] ?></span>
    </div>
    <div class="inside-demographic-wrap-second">
        <div class="demographic-third">
            <input type="radio" id="Demographic19" name="D5" value="1" required>
            <label for="Demographic19">Начално</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic20" name="D5" value="2" required>
            <label for="Demographic20">Основно</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic21" name="D5" value="3" required>
            <label for="Demographic21">Средно общообразователно</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic22" name="D5" value="4" required>
            <label for="Demographic22">Средно специализирано общообразователно (езикова или природоматематическа
                гимназия)</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic23" name="D5" value="5" required>
            <label for="Demographic23">Средно образование в училище по спорт или изкуства</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic24" name="D5" value="6" required>
            <label for="Demographic24">Полувисше</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic25" name="D5" value="7" required>
            <label for="Demographic25">Колеж</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic26" name="D5" value="8" required>
            <label for="Demographic26">Висше бакалавър</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic27" name="D5" value="9" required>
            <label for="Demographic27">Висше магистър</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic28" name="D5" value="10" required>
            <label for="Demographic28">Кандидат на науките / доктор</label>
        </div>
    </div>
</fieldset>

<fieldset class="field-wrapper">
    <div class="inside-demographic-wrap-first">
        <span><?= $content['demographicKeys'][5]; ?>. <?= $content['demographic'][6] ?></span>
    </div>
    <div class="inside-demographic-wrap-second">
        <div class="demographic-third">
            <input type="radio" id="Demographic29" name="D6" value="1" required>
            <label for="Demographic29">Столица</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic30" name="D6" value="2" required>
            <label for="Demographic30">Областен град</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic31" name="D6" value="3" required>
            <label for="Demographic31">Необластен град</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic32" name="D6" value="4" required>
            <label for="Demographic32">Село</label>
        </div>
    </div>
</fieldset>

<fieldset class="field-wrapper">
    <div class="inside-demographic-wrap-first">
        <span><?= $content['demographicKeys'][6]; ?>. <?= $content['demographic'][7] ?></span>
    </div>
    <div class="inside-demographic-wrap-second">
        <div class="demographic-third">
            <input type="radio" id="Demographic33" name="D7" value="1" required>
            <label for="Demographic33">Парите (почти) винаги не ни достигат</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic35" name="D7" value="2" required>
            <label for="Demographic35">Парите често не ни достигат</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic36" name="D7" value="3" required>
            <label for="Demographic36">Парите са точно толкова, колкото да покриват нуждите ни, но без да
                спестяваме</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic37" name="D7" value="4" required>
            <label for="Demographic37">Имаме достатъчно пари да покриваме нуждите си и понякога, да спестяваме</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic38" name="D7" value="5" required>
            <label for="Demographic38">Имаме пари и успяваме да спестяваме</label>
        </div>
    </div>
</fieldset>

<fieldset class="field-wrapper">
    <div class="inside-demographic-wrap-first">
        <span><?= $content['demographicKeys'][7]; ?>. <?= $content['demographic'][8] ?></span>
    </div>
    <div class="inside-demographic-wrap-second">
        <div class="demographic-third">
            <input type="radio" id="Demographic41" name="D8" value="1" required>
            <label for="Demographic41">Учащ/ученик или студент</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic42" name="D8" value="2" required>
            <label for="Demographic42">Работещ на половин работен ден</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic43" name="D8" value="3" required>
            <label for="Demographic43">Работещ на пълен работен ден</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic44" name="D8" value="4" required>
            <label for="Demographic44">Безработен</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic45" name="D8" value="5" required>
            <label for="Demographic45">Домакиня/по майчинство</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic46" name="D8" value="6" required>
            <label for="Demographic46">Пенсионер</label>
        </div>
    </div>
</fieldset>
<fieldset class="field-wrapper">
    <div class="inside-demographic-wrap-first">
        <span><?= $content['demographicKeys'][8]; ?>. <?= $content['demographic'][9] ?></span>
    </div>
    <div class="inside-demographic-wrap-second">
        <div class="demographic-third">
            <input type="radio" id="Demographic47" name="D9" value="1" required>
            <label for="Demographic47">До 500 лв</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic48" name="D9" value="2" required>
            <label for="Demographic48">500-1000 лв</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic49" name="D9" value="3" required>
            <label for="Demographic49">1500-2000 лв</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic50" name="D9" value="4" required>
            <label for="Demographic50">2000-2500 лв</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic51" name="D9" value="5" required>
            <label for="Demographic51">Над 2500 лв</label>
        </div>
    </div>
</fieldset>
<fieldset class="field-wrapper">
    <div class="inside-demographic-wrap-first">
        <span><?= $content['demographicKeys'][9]; ?>. <?= $content['demographic'][10] ?></span>
    </div>
    <div class="inside-demographic-wrap-second">
        <div class="demographic-third">
            <input type="radio" id="Demographic52" name="D10" value="1" required>
            <label for="Demographic52">Генерални директори, собственици на голям бизнес, президенти на фирми, ръководещи повече от 30 човека. Професионалисти на върха на своята професия, която изисква високо образование.;</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic53" name="D10" value="2" required>
            <label for="Demographic53">Доктори, адвокати, архитекти, университетски преподаватели и всички други, които имат нужда от висше образование  в тяхната професия. Ръководители, които пряко имат 4 – 29 подчинени.</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic54" name="D10" value="3" required>
            <label for="Demographic54">Духовни лица, супервайзери / координатори/, собственици на малък бизнес до 4 човека, ръководители на малки отдели с до 4 подчинени, студенти и всички други, занимаващи се с не-физически труд, които не са класирани в категории А и В. Учители, програмисти, търговци и т.н.</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic55" name="D10" value="4" required>
            <label for="Demographic55">Занимаващи се с физически труд, които имат нужда от някакъв вид образование и
                квалификация за упражняване на тяхната професия (без шофьорска книжка или други общи квалификации). Занаятчии, полицаи, строители, хлебари, готвачи, фризьори, шофьори, шофьори на автобуси, медицински сестри, детегледачки, пожарникари.</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic56" name="D10" value="5" required>
            <label for="Demographic56">Практикуващи физически труд, не-изискващ квалификация. Продавачи, келнери,
                работници, кондуктори, шофьори на такси, работници на поточна линия.</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic57" name="D10" value="6" required>
            <label for="Demographic57">Пенсионери без допълнителни доходи, безработни от повече от 6 месеца,
                всички останали, разчитащи основно на социални осигуровки.</label>
        </div>
    </div>
</fieldset>
<fieldset class="field-wrapper">
    <div class="inside-demographic-wrap-first">
        <span><?= $content['demographicKeys'][10]; ?>. <?= $content['demographic'][11] ?></span>
    </div>
    <div class="inside-demographic-wrap-second">
        <div class="demographic-third">
            <input type="radio" id="Demographic58" name="D11" value="1" required>
            <label for="Demographic58">По-малко от година</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic59" name="D11" value="2" required>
            <label for="Demographic59">1-3 години</label>
        </div>
        <div class="demographic-third">
            <input type="radio" id="Demographic60" name="D11" value="3" required>
            <label for="Demographic60">Над 3 години</label>
        </div>
    </div>
</fieldset>
<fieldset class="field-wrapper">
    <div class="inside-demographic-wrap-first">
        <span><?= $content['demographicKeys'][11]; ?>. <?= $content['demographic'][12] ?></span>
    </div>
    <div class="inside-demographic-wrap-second">
        <div class="demographic-third">
            <input type="text" id="Demographic61" name="D12" required/>
        </div>
    </div>
</fieldset>

</fieldset>
</form>
