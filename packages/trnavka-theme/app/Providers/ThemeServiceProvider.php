<?php

namespace App\Providers;

use App\Repositories\CampaignRepository;
use App\Services\WordPress;
use Illuminate\Support\ServiceProvider;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\Extension\DependencyInjection\DependencyInjectionExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\FormRendererInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\ResolvedFormTypeFactory;
use Symfony\Component\Validator\Validation;
use Twig\Environment;
use Twig\Loader\ChainLoader;
use Twig\Loader\FilesystemLoader;
use Twig\RuntimeLoader\FactoryRuntimeLoader;

class ThemeServiceProvider extends ServiceProvider
{
    public array $singletons = [
        CampaignRepository::class => CampaignRepository::class,
        WordPress::class => WordPress::class,
    ];

    public function boot()
    {
        define('DEFAULT_FORM_THEME', 'form_div_layout.html.twig');

//        $csrfTokenManager = new CsrfTokenManager();

        $twig = $this->getTwigEnvironment();
        $loader = $twig->getLoader();

        if (!$loader instanceof ChainLoader) {
            $loader = new ChainLoader([$loader]);
            $twig->setLoader($loader);
        }

        $loader->addLoader(new FilesystemLoader([
            $this->app->resourcePath() . '/views/forms/',
            dirname((new \ReflectionClass(FormExtension::class))->getFileName()) . '/../Resources/views/Form',
        ]));

        $twig->addRuntimeLoader(new FactoryRuntimeLoader(array(
            FormRenderer::class => function () {
                return $this->app->make(FormRenderer::class);
            }
        )));

        $twig->addFilter(new \Twig\TwigFilter('trans', function ($id = null, $replace = [], $locale = null) {
            if (empty($id)) {
                return '';
            }
            return $id;
        }));


//        $formEngine = new TwigRendererEngine(array(DEFAULT_FORM_THEME), $twig);
//        $twig->addExtension(new TranslationExtension($translator));
        $twig->addExtension(new FormExtension());
    }

    public function register()
    {
        $this->app->singleton(TwigRendererEngine::class, function ($app) {
            return new TwigRendererEngine(['bootstrap_5_horizontal_layout.html.twig', 'fields.twig'], $this->getTwigEnvironment());
        });

        $this->app->singleton(FormRenderer::class, function ($app) {
            return new FormRenderer($app->make(TwigRendererEngine::class));
        });

        $this->app->alias(FormRenderer::class, FormRendererInterface::class);

        $this->app->bind('form.extensions', function ($app) {
            return [
                new ValidatorExtension(Validation::createValidator()),
            ];
        });

        $this->app->singleton(FormFactory::class, function ($app) {
            return Forms::createFormFactoryBuilder()
                ->addExtensions($app['form.extensions'])
//                ->addTypeExtensions($app['form.type.extensions'])
//                ->addTypeGuessers($app['form.type.guessers'])
//                ->setResolvedTypeFactory($app['form.resolved_type_factory'])
                ->getFormFactory();
        });
    }

    protected function getTwigEnvironment(): Environment
    {
        if (!$this->app->bound(Environment::class)) {
            $this->app->singleton(Environment::class, function () {
                return new Environment(new ChainLoader([]), [
                    'debug' => 'development' === $this->app->environment(),
                    'cache' => $this->app->storagePath() . '/framework/views/twig',
                ]);
            });
        }

        return $this->app->make(Environment::class);
    }
}
