<?php

namespace App\DataFixtures;

use App\Entity\{Role, Classe, Utilisateur, Creneau, Eleve, Appel, Presence, JournalAudit};
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Rôles
        $roles = [];
        foreach (['ROLE_ADMIN', 'ROLE_PROF', 'ROLE_VIE_SCOLAIRE'] as $nom) {
            $role = (new Role())->setNomRole($nom);
            $manager->persist($role);
            $roles[$nom] = $role;
        }

        // Classes
        $classes = [];
        foreach (['SIO1', 'SIO2', 'CIEL1', 'CIEL2'] as $nom) {
            $classe = (new Classe())->setNomClasse($nom)->setNiveau(str_ends_with($nom, '1') ? '1ère année' : '2ème année');
            $manager->persist($classe);
            $classes[] = $classe;
        }

        // Utilisateurs
        $profs = [];
        for ($i = 0; $i < 6; $i++) {
            $u = (new Utilisateur())
                ->setNom($faker->lastName())
                ->setPrenom($faker->firstName())
                ->setEmail($faker->unique()->safeEmail())
                ->setRole($roles['ROLE_PROF']);
            $u->setPassword($this->hasher->hashPassword($u, 'password'));
            $manager->persist($u);
            $profs[] = $u;
        }
        $admin = (new Utilisateur())
            ->setNom('Admin')->setPrenom('Assiduo')
            ->setEmail('admin@assiduo.test')
            ->setRole($roles['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin'));
        $manager->persist($admin);

        // Créneaux (liés à un prof et planifiés pour des classes)
        $creneaux = [];
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
        for ($i = 0; $i < 15; $i++) {
            $debut = new \DateTimeImmutable(sprintf('%02d:00', $faker->numberBetween(8, 16)));
            $c = (new Creneau())
                ->setJourSemaine($faker->randomElement($jours))
                ->setHeureDebut($debut)
                ->setHeureFin($debut->modify('+2 hours'))
                ->setUtilisateur($faker->randomElement($profs))
                ->addClass($faker->randomElement($classes));
            $manager->persist($c);
            $creneaux[] = $c;
        }

        // Élèves
        $eleves = [];
        for ($i = 0; $i < 40; $i++) {
            $e = (new Eleve())
                ->setNom($faker->lastName())
                ->setPrenom($faker->firstName())
                ->setDateNaissance(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-25 years', '-18 years')))
                ->setClasse($faker->randomElement($classes));
            $manager->persist($e);
            $eleves[] = $e;
        }

        // Appels + présences
        foreach ($creneaux as $creneau) {
            $date = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 months', 'now'));
            $appel = (new Appel())
                ->setDateAppel($date)
                ->setHorodatageValidation($date->modify('+10 minutes'))
                ->setVerrouille($faker->boolean(70))
                ->setCreneau($creneau);
            $manager->persist($appel);

            foreach ($eleves as $eleve) {
                if ($eleve->getClasse() !== null && $creneau->getClasses()->contains($eleve->getClasse())) {
                    $status = $faker->randomElement(['présent', 'présent', 'présent', 'absent', 'retard']);
                    $p = (new Presence())
                        ->setStatus($status)
                        ->setDureeRetard($status === 'retard' ? $faker->numberBetween(5, 30) : 0)
                        ->setJustifie($status !== 'présent' ? $faker->boolean(40) : false)
                        ->setMotif($status === 'absent' ? $faker->randomElement(['Maladie', 'Transport', 'Rendez-vous médical']) : null)
                        ->setDateQualification($date)
                        ->setAppel($appel)
                        ->setEleve($eleve);
                    $manager->persist($p);
                }
            }
        }

        // Journal d'audit
        for ($i = 0; $i < 20; $i++) {
            $manager->persist(
                (new JournalAudit())
                    ->setDateHeure(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 month', 'now')))
                    ->setAction($faker->randomElement(['LOGIN', 'CREATE_APPEL', 'UPDATE_PRESENCE']))
                    ->setAutorisee($faker->boolean(90))
                    ->setTypeRessource($faker->randomElement(['Appel', 'Presence', 'Eleve']))
                    ->setIdRessource($faker->numberBetween(1, 50))
                    ->setUtilisateur($faker->randomElement($profs))
            );
        }

        $manager->flush();
    }
}