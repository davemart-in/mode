# Mode

Turn WordPress into a set of **focused spaces**. Activate a mode and it appears in
a "Mode" menu in the toolbar; click in and the left nav becomes a distraction-free
space showing only that mode's screens — the masterbar and standard admin chrome
stay exactly as core renders them (no block-editor full-screen takeover).

> **Status: clickable prototype.** The three built-in modes render polished,
> *static* mock screens. Nothing is saved yet — the goal is a believable,
> navigable preview of the idea.

## What's included

- **Settings → Modes** — a card per registered mode with an Activate / Deactivate
  toggle. Activation is stored in the `mode_active_modes` option.
- **Toolbar Mode selector** — a "Mode" dropdown on the far right of the toolbar
  (just left of the account menu) that lists active modes and deep-links to
  Settings → Modes. Because it's always present, you can switch from one mode to
  another without first returning to wp-admin.
- **Focused spaces** — entering a mode swaps the left nav for a back row
  (`‹ Mode` → Dashboard) plus that mode's screens. Leaving (the back row) restores
  the normal admin menu untouched.
- **Three built-in modes**, each leading with a Dashboard:
  - **Newsletter** — Dashboard, Subscribers, Broadcasts, Templates
  - **Podcast** — Dashboard, Episodes, Recording, Distribution
  - **Social** — Dashboard, Composer, Calendar, Accounts

## How it matches core

The UI is built from WordPress's own admin components — `.wrap`, `.wp-list-table`,
`.card`, `.button`, `.subsubsub`, the toolbar API, and the real admin-menu markup —
so it reads as native wp-admin. The only custom CSS (`assets/css/`) covers the
handful of pieces core has no class for: stat tiles, content cards, status pills,
simple charts, the template grid, and the toolbar/back-row accents.

## Extending: register your own mode

Modes are extensible by design. Built-in modes and third-party plugins register the
same way — on the `mode_register` action, via the `mode_register_mode()` helper:

```php
add_action( 'mode_register', function () {
	mode_register_mode( array(
		'id'          => 'support',                 // unique, lowercase
		'label'       => 'Support',
		'icon'        => 'dashicons-sos',           // dashicon for the toolbar + nav
		'description' => 'Triage and answer tickets.',
		'position'    => 40,                         // order in the selector
		'screens'     => array(
			array(
				'slug'   => 'dashboard',
				'label'  => 'Dashboard',
				'icon'   => 'dashicons-dashboard',
				'render' => 'my_support_dashboard',  // any callable that echoes the screen
			),
			array(
				'slug'   => 'tickets',
				'label'  => 'Tickets',
				'icon'   => 'dashicons-tickets-alt',
				'render' => 'my_support_tickets',
			),
		),
	) );
} );

function my_support_dashboard() {
	echo '<div class="wrap"><h1>Support</h1>…</div>';
}
```

Once registered, your mode shows up on **Settings → Modes** and behaves exactly
like the built-ins. A screen's `render` callback just echoes the page body inside a
standard `.wrap`; reuse the shared `.mode-*` classes for stat tiles, cards, pills,
etc. (see `includes/modes/*-screens.php`).

### Helpers

- `mode_register_mode( array $args )` — register a mode.
- `mode_get_active()` / `mode_get_all()` / `mode_get( $id )` — query the registry.
- `mode_current()` — the `Mode` for the current request, or `null`.
- `mode_badge( $label, $variant )` — a status pill for screen markup.
- `Mode_Space::screen_url( $mode, $screen_slug )` — link between a mode's screens.

## Structure

```
mode/
  mode.php                       Plugin header, constants, bootstrap (fires mode_register)
  uninstall.php                  Removes the mode_active_modes option
  includes/
    class-mode.php               Mode value object (id, label, icon, screens…)
    class-mode-registry.php      Registry of modes + active state
    functions.php                Public API + helpers
    class-mode-settings.php      Settings → Modes screen
    class-mode-admin-bar.php     Toolbar Mode selector
    class-mode-admin-menu.php    Routable mode pages + focused-nav swap + page titles
    class-mode-space.php         Screen router for a mode
    modes/                       Built-in modes + their static mock screens
  assets/css/                    mode-admin.css, mode-admin-bar.css
```

## Requirements

- WordPress 6.4+
- PHP 7.4+
