<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Spatie\SchemaOrg\Article;
use Spatie\SchemaOrg\Schema;

class SchemaOrg
{
    public function article(): ?string
    {
        try {
            $page = $this->params->get('article');
            $webPage = Schema::webPage()->url($page['permalink']);
            $organization = Schema::organization()
                ->name(config('app.name'));

            $article = Schema::article()
                ->name($page['title'])
                ->if(!empty($page['author']), function (Article $article) use ($page) {
                    $author = Schema::person()
                        ->name($page['author'][0]['name'])
                        ->jobTitle($page['author'][0]['description']);

                    return $article->author($author);
                })
                ->if(isset($page['cover_image']), fn(Article $article) => $article->image(asset($page['cover_image'])))
                ->url($page['permalink'])
                ->headline($page['title'])
                ->datePublished($page['updated_at'])
                ->mainEntityOfPage($webPage)
                ->publisher($organization);

            return $article->toScript();
        } catch (Exception $e) {
            Log::error($e);

            return null;
        }
    }

    public function organization(): ?string
    {
        try {
            $founders = array_map(static function ($founder) {
                return Schema::person()->name($founder['name']);
            }, __('schema.organization.founders'));

            $address = Schema::postalAddress()
                ->streetAddress(__('schema.organization.address.street_address'))
                ->addressLocality(__('schema.organization.address.address_locality'))
                ->postalCode(__('schema.organization.address.postal_code'))
                ->addressCountry(__('schema.organization.address.address_country'));

            $contactPoint = Schema::contactPoint()
                ->contactType(__('schema.organization.contact_point.contact_type'))
                ->telephone(__('schema.organization.contact_point.telephone'))
                ->areaServed(__('schema.organization.contact_point.area_served'))
                ->availableLanguage(__('schema.organization.contact_point.available_language'))
                ->email(__('schema.organization.contact_point.email'));

            $offers = [
                Schema::offer()->itemOffered(Schema::service()->name('Professional Laravel Developers')),
                Schema::offer()->itemOffered(Schema::service()->name('Software Development')),
                Schema::offer()->itemOffered(Schema::service()->name('IT Business Consulting')),
                Schema::offer()->itemOffered(Schema::service()->name('IT Outsourcing/Outstaffing')),
                Schema::offer()->itemOffered(Schema::service()->name('UI/UX Design')),
                Schema::offer()->itemOffered(Schema::service()->name('Custom Software Development')),
            ];

            $offerCatalog = Schema::offerCatalog()
                ->name('Software Development Services')
                ->itemListElement($offers);

            $localBusiness = Schema::onlineBusiness()
                ->name(__('schema.organization.name'))
                ->url(__('schema.organization.url'))
                ->description(__('schema.organization.description'))
                ->foundingDate(__('schema.organization.founding_date'))
                ->founders($founders)
                ->address($address)
                ->contactPoint($contactPoint)
                ->awards(__('schema.organization.awards'))
                ->hasOfferCatalog($offerCatalog)
                ->sameAs(__('schema.organization.same_as'));

            return $localBusiness->toScript();
        } catch (Exception $e) {
            Log::error($e);

            return null;
        }
    }

    public function reviews(): array
    {
        try {
            $home = Entry::whereCollection('pages')->filter(fn($page) => $page->slug === 'home')->first();
            $reviewList = collect($home->sections)->filter(fn($section) => $section->type === 'reviews')->first()->review_list;
            $reviewsSchema = [];

            foreach ($reviewList as $reviewData) {
                $reviewSchema = Schema::review()
                    ->itemReviewed(Schema::onlineBusiness()
                        ->name('Lionix')
                        ->url('https://lionix.io'))
                    ->author(Schema::person()
                        ->name($reviewData['name']))
                    ->reviewRating(Schema::rating()
                        ->ratingValue(5)
                        ->bestRating(5))
                    ->reviewBody($reviewData['review'])
                    ->datePublished(now());

                // Add each review schema to the reviews array
                $reviewsSchema[] = $reviewSchema;
            }

            // Convert the array of review schemas into JSON-LD scripts
            return array_map(static function ($schema) {
                return $schema->toScript();
            }, $reviewsSchema);
        } catch (Exception $e) {
            Log::error($e);

            return [];
        }
    }
}
