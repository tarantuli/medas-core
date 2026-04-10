# Events

The event system allows decoupled communication between parts of the application. A service dispatches an event object; any number of listeners respond to it. The dispatcher is PSR-14 compliant.

There are two kinds of events: **plain events** (fire-and-forget notifications) and **votes** (access control decisions that listeners either allow or deny).

## Dispatching an event

Use the `dispatch()` global function or resolve `EventDispatcher` directly. The same object is returned after all listeners have processed it, so any state written by listeners is available on the return value.

```php
$event = dispatch(new UserRegistered($user));
```

For events that are expensive to construct and may have no listeners, use `lazyDispatch()`. The object is only created if at least one listener is registered:

```php
$event = service(EventDispatcher::class)->lazyDispatch(
    DebugInformation::class,
    fn() => new DebugInformation('Processing file %s', $path),
);
```

## Listening to an event

Add a `#[EventListener]` method to any `#[Service]` class. The method's first parameter type determines which event it receives:

```php
#[Service]
class UserWelcomeMailer
{
    #[EventListener]
    public function onUserRegistered(UserRegistered $event): void
    {
        $this->mailer->send($event->user->email, 'Welcome!');
    }
}
```

## Votes

A vote is a special event used for access control. Extend `BasicVote` and dispatch it. Listeners set `$vote->allowedAccess` to `AllowedAccess::Allowed`, `AllowedAccess::Denied`, or `AllowedAccess::Unauthenticated`. Once any listener sets a non-`Pending` value, propagation stops.

Use `allowElseThrow()` to dispatch a vote and automatically throw if access is not granted:

```php
allowElseThrow(
    new CanEditPost($post, $user),
    fn() => new AccessDeniedException(),
);
```

### AllowedAccess values

| Value | Meaning |
|---|---|
| `Pending` | No listener has decided yet (initial state) |
| `Allowed` | Access is granted |
| `Denied` | Access is denied (user is authenticated but not permitted) |
| `Unauthenticated` | Access is denied because the user is not authenticated |

### Defining a vote

```php
use Medas\Core\Events\BasicVote;

class CanEditPost extends BasicVote
{
    public function __construct(
        public readonly Post $post,
        public readonly User $user,
    ) {
    }
}
```

### Handling a vote

```php
#[Service]
class PostAccessVoter
{
    #[EventListener]
    public function onCanEditPost(CanEditPost $vote): void
    {
        if (!$vote->user->isAuthenticated()) {
            $vote->allowedAccess = AllowedAccess::Unauthenticated;
            return;
        }

        $vote->allowedAccess = $vote->post->authorId === $vote->user->id
            ? AllowedAccess::Allowed
            : AllowedAccess::Denied;
    }
}
```
