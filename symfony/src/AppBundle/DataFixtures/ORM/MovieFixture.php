<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MovieFixture extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load( ObjectManager $manager )
    {
        $movie = new Movie();
        $movie->setTitle("Deadpool");
        $movie->setShortPlot("Une petite description");
        $movie->setLongPlot("Deadpool, est l'anti-héros le plus atypique de l'univers Marvel. A l'origine, il s'appelle Wade Wilson : un ancien militaire des Forces Spéciales devenu mercenaire. Après avoir subi une expérimentation hors norme qui va accélérer ses pouvoirs de guérison, il va devenir Deadpool. Armé de ses nouvelles capacités et d'un humour noir survolté, Deadpool va traquer l'homme qui a bien failli anéantir sa vie.");
        $movie->setReleaseDate(new \DateTime());
        $movie->setPoster("https://upload.wikimedia.org/wikipedia/en/4/46/Deadpool_poster.jpg");
        $movie->setSlug("deadpool");
        $movie->setRuntime(180);

        $manager->persist($movie);
        $manager->flush();

        $movie = new Movie();
        $movie->setTitle("Logan");
        $movie->setShortPlot("Dans un futur proche, un certain Logan, épuisé de fatigue.");
        $movie->setLongPlot("Dans un futur proche, un certain Logan, épuisé de fatigue, s’occupe d’un Professeur X souffrant, dans un lieu gardé secret à la frontière Mexicaine. Mais les tentatives de Logan pour se retrancher du monde et rompre avec son passé vont s’épuiser lorsqu’une jeune mutante traquée par de sombres individus va se retrouver soudainement face à lui.");
        $movie->setReleaseDate(new \DateTime());
        $movie->setPoster("http://t1.gstatic.com/images?q=tbn:ANd9GcQqwipefq8OGT-UoENxoeSi5dlW9Uzb9sR2PLxgc2CRprlJtsB6");
        $movie->setSlug("logan");
        $movie->setRuntime(180);

        $manager->persist($movie);
        $manager->flush();

        $movie = new Movie();
        $movie->setTitle("Les gardiens de la Galaxie Vol. 2");
        $movie->setShortPlot("Dans un futur proche, un certain Logan, épuisé de fatigue.");
        $movie->setLongPlot("Musicalement accompagné de la \"Awesome Mixtape n°2\" (la musique qu'écoute Star-Lord dans le film), Les Gardiens de la galaxie 2 poursuit les aventures de l'équipe alors qu'elle traverse les confins du cosmos. Les gardiens doivent combattre pour rester unis alors qu'ils découvrent les mystères de la filiation de Peter Quill. Les vieux ennemis vont devenir de nouveaux alliés et des personnages bien connus des fans de comics vont venir aider nos héros et continuer à étendre l'univers Marvel.");
        $movie->setReleaseDate(new \DateTime());
        $movie->setPoster("http://t1.gstatic.com/images?q=tbn:ANd9GcS1EM6lY0Ptl1f9N1Nu1U33mP9Wkdb1mTnprVp0H0aIoTp8zR_F");
        $movie->setSlug("les_gardiens");
        $movie->setRuntime(180);
        $manager->persist($movie);
        $manager->flush();

        $movie = new Movie();
        $movie->setTitle("Batman v Superman : L'Aube de la justice");
        $movie->setShortPlot("Craignant que Superman n'abuse de sa toute-puissance, le Chevalier noir décide de l'affronter.");
        $movie->setLongPlot("Craignant que Superman n'abuse de sa toute-puissance, le Chevalier noir décide de l'affronter : le monde a-t-il davantage besoin d'un super-héros aux pouvoirs sans limite ou d'un justicier à la force redoutable mais d'origine humaine ? Pendant ce temps-là, une terrible menace se profile à l'horizon…");
        $movie->setReleaseDate(new \DateTime());
        $movie->setPoster("http://t3.gstatic.com/images?q=tbn:ANd9GcTMvU07lxL3CYcLVM2P8B02ogNYUDb0XJYMVQpCJ8J1Ig4s1V7l");
        $movie->setSlug("batman_vs_superman");
        $movie->setRuntime(180);
        $manager->persist($movie);
        $manager->flush();

        $movie = new Movie();
        $movie->setTitle("Ninja Turles 2");
        $movie->setShortPlot("Michelangelo, Donatello, Leonardo et Raphael sont de retour pour affronter des méchants toujours plus forts");
        $movie->setLongPlot("Michelangelo, Donatello, Leonardo et Raphael sont de retour pour affronter des méchants toujours plus forts et impressionnants, aux côtés d’April O’Neil, Vern Fenwick et d’un nouveau venu, le justicier masqué hockeyeur Casey Jones. Après son évasion de prison, Shredder associe ses forces à celles d’un savant fou Baxter Stockman et de deux hommes de main aussi bêtes que costauds, Bebop & Rocksteady. Leur objectif : lancer un plan diabolique pour régner sur le monde entier ! Alors que les Ninja Turtles s’apprêtent à défier Shredder et son nouveau gang, ils doivent rapidement faire face à une menace tout aussi grande : le célèbre Krang !");
        $movie->setReleaseDate(new \DateTime());
        $movie->setPoster("http://t1.gstatic.com/images?q=tbn:ANd9GcRriR6cxIdUJ1oUrr_FqJcPbVFxHMwWVDpln6ZFIu-09LfDD1Yt");
        $movie->setSlug("ninja_turles_2");
        $movie->setRuntime(180);
        $manager->persist($movie);
        $manager->flush();

        $movie = new Movie();
        $movie->setTitle("Doctor Strange");
        $movie->setShortPlot("Doctor Strange suit l'histoire du Docteur Stephen Strange, talentueux neurochirurgien qui, après un tragique accident de voiture");
        $movie->setLongPlot("Doctor Strange suit l'histoire du Docteur Stephen Strange, talentueux neurochirurgien qui, après un tragique accident de voiture, doit mettre son égo de côté et apprendre les secrets d'un monde caché de mysticisme et de dimensions alternatives. Basé à New York, dans le quartier de Greenwich Village, Doctor Strange doit jouer les intermédiaires entre le monde réel et ce qui se trouve au-delà, en utlisant un vaste éventail d'aptitudes métaphysiques et d'artefacts pour protéger le Marvel Cinematic Universe.");
        $movie->setReleaseDate(new \DateTime());
        $movie->setPoster("http://t2.gstatic.com/images?q=tbn:ANd9GcSi4m7sOWvcLmKqkCBrbnCPwgLP1WgO8OtPY50ORA2aQNR11Bg0");
        $movie->setSlug("doctor_strange");
        $movie->setRuntime(180);

        $manager->persist($movie);
        $manager->flush();
    }
}