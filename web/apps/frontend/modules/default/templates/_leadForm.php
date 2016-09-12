<?php echo $form->renderFormTag(url_for('@lead_process'), array('class' => 'form form--tab--1', 'novalidate' => 'novalidate')) ?>
    <div class="tab__split tab__split--1">
        <ul class="checks">
            <li class="check check--pardubice">
                <div>
                    <svg class="icon icon--pardubice">
                        <use xlink:href="/img/sprite.svg#pardubice"></use>
                    </svg>
                </div><span>Jsem z oblasti Pardubicka.</span>
            </li>
            <li class="check check--best">
                <div>
                    <svg class="icon icon--best">
                        <use xlink:href="/img/sprite.svg#best"></use>
                    </svg>
                </div><span>Chci získat nejvýhodnější nabídku na trhu.</span>
            </li>
            <li class="check check--meeting">
                <div>
                    <svg class="icon icon--meeting">
                        <use xlink:href="/img/sprite.svg#meeting"></use>
                    </svg>
                </div><span>Chci zdarma nezávaznou konzultaci.</span>
            </li>
        </ul>
    </div>
    <div class="tab__split tab__split--2">
        <div class="form__row"><span class="label">Výše hypotéky</span>
            <div id="moneyValue"></div>
            <?php echo $form['amount']->render(array('id' => 'moneyValueInput')) ?>
        </div><?php /* pro zobrazeni chyboveho stavu staci pridat tridu .form_row--error */ ?>
        <div class="form__row form__row--margin-top<?php echo $form['name']->hasError() ?  ' form_row--error' : '' ?>">
            <?php echo $form['name']->render(array('placeholder' => 'Karel Novák')) ?>
        </div>
        <div class="form__row form__row--margin-bottom<?php echo $form['contact']->hasError() ?  ' form_row--error' : '' ?>">
            <?php echo $form['contact']->render(array('placeholder' => 'Telefon nebo e-mail')) ?>
        </div>
        <div class="form__row form__row--submit"><?php /* pro zobrazeni staci oddelat tridu .hidden */ ?>
            <?php $fieldMessages = array() ?>
            <?php foreach(array('name','contact') as $field): ?>
                <?php if ($form[$field]->hasError()): ?>
                    <?php $fieldMessages[] = $form[$field]->getError()->getMessage() ?>
                <?php endif ?>
            <?php endforeach ?>

            <?php if (count($fieldMessages)): ?>
                <div class="form__layer--error">
                    <?php foreach($fieldMessages as $fieldMessage): ?>
                        <p class="form__layer--error__text"><?php echo $fieldMessage ?></p>
                    <?php endforeach ?>
                </div>
            <?php endif ?>

            <button type="submit" class="button">Odeslat</button><span class="button__info">Chci získat nezávaznou&nbsp;konzultaci!</span>
        </div><?php /* pro zobrazeni staci oddelat tridu .hidden */ ?>
        <?php if ($sf_user->hasFlash('form_successful')): ?>
            <div class="form__layer--success">
                <div class="form__layer--success__content">
                    <svg class="icon icon--check">
                        <use xlink:href="/img/sprite.svg#check"></use>
                    </svg><strong class="form__layer--success__title">Děkujeme</strong><span class="form__layer--success__text">Do dalšího dne se vám ozveme.</span>
                </div>
            </div>
        <?php endif ?>
    </div>
    <?php echo $form['type']->render() ?>
    <?php echo $form['answer_to_the_ultimate_question_of_life_the_universe_and_everything']->render() ?>
    <?php echo $form['_csrf_token']->render() ?>
</form>