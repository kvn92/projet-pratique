<?php

namespace App\Tests\Unit\Model;

use App\Entity\Category;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

class CategoryTest extends TestCase
{


    public function getModel(): Category
    {
        return new Category('kvvv');
    }



    #[Test]
    public function ValidationNomTropCourt()
    {
        // On s'assure que le builder est complet
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        // On crée une catégorie invalide (2 lettres alors que le min est 3)
        $model = new Category("kv");

        $errors = $validator->validate($model);

        // On affiche les erreurs si le test échoue pour comprendre ce qui ne va pas
        if (count($errors) === 0) {
            dump("Attention : Aucune erreur trouvée. Vérifie l'import de Assert dans Category.php");
        }

        // Tu attendais 4, mais normalement une règle de longueur non respectée = 1 erreur.
        $this->assertCount(1, $errors, "Il devrait y avoir 1 erreur car 'ke' est trop court.");
    }
}
