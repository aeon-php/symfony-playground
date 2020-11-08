<?php

declare(strict_types=1);

namespace App\Form;

use Aeon\Calendar\Gregorian\Calendar;
use Aeon\Calendar\TimeUnit;
use Aeon\Symfony\AeonBundle\Form\Type\AeonDateTimeType;
use Aeon\Symfony\AeonBundle\Form\Type\AeonDayType;
use Aeon\Symfony\AeonBundle\Form\Type\AeonTimeType;
use Aeon\Symfony\AeonBundle\Form\Type\AeonTimeZoneType;
use Aeon\Symfony\AeonBundle\Validator\Constraints\Before;
use Aeon\Symfony\AeonBundle\Validator\Constraints\Holiday;
use Aeon\Symfony\AeonBundle\Validator\Constraints\NotHoliday;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AeonFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder->add('day', AeonDayType::class, [
            'data' =>  $options['calendar']->currentDay(),
        ]);
        $builder->add('datetime', AeonDateTimeType::class, [
            'data' =>  $options['calendar']->now(),
        ]);
        $builder->add('time', AeonTimeType::class, [
            'data' =>  $options['calendar']->now()->time(),
        ]);
        $builder->add('timezone', AeonTimeZoneType::class, [
            'data' => $options['calendar']->timezone()->name(),
        ]);

        $builder->add('holiday', AeonDayType::class, [
            'constraints' => [new Holiday(['countryCode' => 'US'])],
            'data' => $options['calendar']->currentYear()->january()->firstDay(),
        ]);

        $builder->add('not_holiday', AeonDayType::class, [
            'constraints' => [new NotHoliday(['countryCode' => 'US'])],
            'data' => $options['calendar']->currentYear()->january()->firstDay()->next(),
        ]);

        $builder->add('datetime_compare_1', AeonDateTimeType::class, [
            'widget' => 'single_text',
            'input' => 'string',
            'data' => $options['calendar']->now()->sub(TimeUnit::second())->format('Y-m-d H:i:s'),
            'constraints' => [
                new Before(['propertyPath' => 'parent.all[datetime_compare_2].data']),
            ],
        ]);
        $builder->add('datetime_compare_2', AeonDateTimeType::class, [
            'widget' => 'single_text',
            'input' => 'string',
            'data' => $options['calendar']->now()->format('Y-m-d H:i:s'),
        ]);

        $builder->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        parent::configureOptions($resolver);

        $resolver->setRequired('calendar');
        $resolver->setAllowedTypes('calendar', Calendar::class);
    }
}
