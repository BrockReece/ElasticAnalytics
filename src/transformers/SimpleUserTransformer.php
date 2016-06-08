<?php
namespace BrockReece\ElasticAnalytics\Transformers;

use App\Model\User;

class SimpleUserTransformer extends \League\Fractal\TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'languages',
        'qualifications',
        'countries',
        'availability'
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'languages',
        'qualifications',
        'countries',
        'availability'
    ];

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(User $user)
    {
        $name = $user->alias ?: $user->first_name . ' ' . $user->last_name;

        return [
            'id' => (int) $user->id,
            'name' => $name,
            'name_clean' => \App\Library\Diacritics::remove($name),
            'email' => $user->email,
            'code' => $user->code,
            'system' => $user->system,
            'rate'   => !$user->system ? $user->rate : null,
            'avatar' => $user->getAvatarUrl(),
            'score' => $user->documentScore(),
            //'last_taskable' => $user->lastClient ? $user->lastClient->completed_at : null,
            'last_login' => $user->last_active_at ?: $user->last_login_at,
            'links' => [
                [
                    'rel' => 'self',
                    'uri' => url('/api/user', $user->id),
                ]
            ],
        ];
    }

    /**
     * Include Language names
     *
     * @param User $user
     * @return League\Fractal\ItemResource
     */
    public function includeLanguages(User $user)
    {
        return $this->collection($user->languages, function($language) {
            return $language['name'];
        });
    }

    /**
     * Include Country names
     *
     * @param User $user
     * @return League\Fractal\ItemResource
     */
    public function includeCountries(User $user)
    {
        return $this->collection($user->countries, function($country) {
            return $country['name'];
        });
    }

    /**
     * Include Qualification names
     *
     * @param User $user
     * @return League\Fractal\ItemResource
     */
    public function includeQualifications(User $user)
    {
        return $this->collection($user->qualifications, function($qualification) {
            return $qualification['name'];
        });
    }

    /**
     * Include Availability
     *
     * @param User $user
     * @return League\Fractal\ItemResource
     */
    public function includeAvailability(User $user)
    {
        return $this->collection($user->availability, function($availability) {
            return $availability['day_of_week'];
        });
    }
}
