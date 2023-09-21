<?php

declare(strict_types=1);

namespace App\Enums;

use App\Concerns\Enums\Arrayable;

enum ActivityDomain: string
{
    use Arrayable;

    case environmental_protection = 'Protecția mediului';
    case education = 'Educație';
    case healthcare = 'Sănătate';
    case human_rights = 'Drepturile omului';
    case rural_development = 'Dezvoltare rurală';
    case disability_support = 'Sprijin dizabilități';
    case gender_equality = 'Egalitate de gen';
    case poverty_reduction = 'Reducerea sărăciei';
    case minority_integration = 'Integrarea minorităților';
    case youth_support = 'Sprijin tineret';
    case elderly_assistance = 'Asistență vârstnici';
    case cultural_heritage = 'Patrimoniu cultural';
    case arts_culture = 'Artă și cultură';
    case sports_recreation = 'Sport și recreere';
    case community_development = 'Dezvoltare comunitară';
    case domestic_violence_prevention = 'Prevenire violență domestică';
    case immigrant_refugee_aid = 'Ajutor imigranți/refugiați';
    case anti_human_trafficking = 'Combatere trafic uman';
    case good_governance = 'Bună guvernare';
    case animal_protection = 'Protecția animalelor';
    case drug_addiction_prevention = 'Prevenire dependență droguri';
    case public_policy_advocacy = 'Advocacy politici publice';
    case anti_discrimination = 'Anti-discriminare';
    case infrastructure_improvement = 'Îmbunătățire infrastructură';
    case social_entrepreneurship = 'Antreprenoriat social';
    case disaster_management = 'Gestionare dezastre';
    case consumer_rights = 'Drepturile consumatorilor';
    case family_support = 'Sprijin familie';
    case volunteering_promotion = 'Promovare voluntariat';
    case legal_assistance = 'Asistență juridică';
    case privacy_protection = 'Protecția vieții private';
    case anti_corruption = 'Combatere corupție';
    case mental_health = 'Sănătate mintală';
    case animal_rights = 'Drepturile animalelor';
    case scientific_research = 'Cercetare științifică';
    case sustainable_development = 'Dezvoltare durabilă';
    case food_security = 'Securitate alimentară';
    case infectious_disease_control = 'Control boli infecțioase';
    case veteran_support = 'Sprijin veterani';
    case regional_international_development = 'Dezvoltare regională/internațională';
}
