<?php
/**
 * Static mock screens for the Social mode.
 *
 * Hard-coded sample data rendered with core admin components plus the shared
 * `.mode-*` styles. A clickable preview only — nothing is saved.
 *
 * @package Mode
 */

defined( 'ABSPATH' ) || exit;

/**
 * URL to another Social screen, for in-prototype navigation.
 *
 * @param string $screen Screen slug.
 * @return string
 */
function mode_social_url( $screen ) {
	$mode = mode_get( 'social' );

	return $mode ? Mode_Space::screen_url( $mode, $screen ) : '#';
}

/**
 * Network presentation metadata (label, dashicon, brand colour).
 *
 * @return array<string,array>
 */
function mode_social_networks() {
	return array(
		'x'         => array( 'X', 'dashicons-twitter', '#000000' ),
		'instagram' => array( 'Instagram', 'dashicons-instagram', '#c13584' ),
		'facebook'  => array( 'Facebook', 'dashicons-facebook', '#1877f2' ),
		'linkedin'  => array( 'LinkedIn', 'dashicons-linkedin', '#0a66c2' ),
		'mastodon'  => array( 'Mastodon', 'dashicons-share', '#6364ff' ),
		'tiktok'    => array( 'TikTok', 'dashicons-video-alt3', '#111111' ),
	);
}

/**
 * A small round network dot.
 *
 * @param string $key Network key.
 * @return string HTML.
 */
function mode_social_dot( $key ) {
	$nets = mode_social_networks();

	if ( ! isset( $nets[ $key ] ) ) {
		return '';
	}

	return sprintf(
		'<span class="mode-dot" style="background:%s"></span>',
		esc_attr( $nets[ $key ][2] )
	);
}

/**
 * Render the Social → Composer screen.
 *
 * @return void
 */
function mode_social_screen_composer() {
	$nets    = mode_social_networks();
	$checked = array( 'x', 'instagram', 'linkedin' );
	?>
	<div class="wrap mode-screen">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Composer', 'mode' ); ?></h1>
		<a href="<?php echo esc_url( mode_social_url( 'calendar' ) ); ?>" class="page-title-action"><?php esc_html_e( 'View calendar', 'mode' ); ?></a>
		<hr class="wp-header-end" />

		<div class="mode-cols">
			<div class="mode-col">
				<div class="mode-card">
					<div class="mode-card__head"><?php esc_html_e( 'New post', 'mode' ); ?></div>
					<div class="mode-card__body">
						<p class="mode-field-label"><?php esc_html_e( 'Post to', 'mode' ); ?></p>
						<div class="mode-nets">
							<?php foreach ( $nets as $key => $net ) : ?>
								<label class="mode-net">
									<input type="checkbox" <?php checked( in_array( $key, $checked, true ) ); ?> />
									<span class="mode-dot" style="background: <?php echo esc_attr( $net[2] ); ?>"></span>
									<?php echo esc_html( $net[0] ); ?>
								</label>
							<?php endforeach; ?>
						</div>

						<p>
							<label class="screen-reader-text" for="mode-social-text"><?php esc_html_e( 'Post text', 'mode' ); ?></label>
							<textarea id="mode-social-text" class="widefat" rows="5">Big news — Mode 1.0 is here. Turn WordPress into a focused space for whatever you do best. 🚀</textarea>
						</p>

						<div class="mode-compose__bar">
							<span class="mode-compose__tools">
								<button type="button" class="button button-small"><span class="dashicons dashicons-format-image"></span> <?php esc_html_e( 'Media', 'mode' ); ?></button>
								<button type="button" class="button button-small"><span class="dashicons dashicons-smiley"></span> <?php esc_html_e( 'Emoji', 'mode' ); ?></button>
								<button type="button" class="button button-small"><span class="dashicons dashicons-admin-links"></span> <?php esc_html_e( 'Link', 'mode' ); ?></button>
							</span>
							<span class="mode-compose__count">126 / 280</span>
						</div>
					</div>
					<div class="mode-card__foot">
						<button type="button" class="button button-primary"><?php esc_html_e( 'Post now', 'mode' ); ?></button>
						<button type="button" class="button"><?php esc_html_e( 'Schedule…', 'mode' ); ?></button>
					</div>
				</div>
			</div>

			<div class="mode-col">
				<div class="mode-card">
					<div class="mode-card__head"><?php esc_html_e( 'Preview', 'mode' ); ?></div>
					<div class="mode-card__body">
						<div class="mode-post">
							<span class="mode-post__avatar" aria-hidden="true">M</span>
							<div class="mode-post__body">
								<p class="mode-post__author"><strong><?php esc_html_e( 'The Mode Show', 'mode' ); ?></strong> <span class="mode-muted">@themodeshow · now</span></p>
								<p class="mode-post__text"><?php esc_html_e( 'Big news — Mode 1.0 is here. Turn WordPress into a focused space for whatever you do best. 🚀', 'mode' ); ?></p>
							</div>
						</div>
					</div>
				</div>

				<div class="mode-card">
					<div class="mode-card__head"><?php esc_html_e( 'Best time to post', 'mode' ); ?></div>
					<div class="mode-card__body">
						<ul class="mode-checklist">
							<li><?php esc_html_e( 'Weekdays 9–11am get the most engagement.', 'mode' ); ?></li>
							<li><?php esc_html_e( 'Add an image to roughly double reach.', 'mode' ); ?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Render the Social → Calendar screen.
 *
 * @return void
 */
function mode_social_screen_calendar() {
	// Mock April 2026: 30 days, first of month offset to a Wednesday.
	$offset = 3;
	$days   = 30;

	// Scheduled posts keyed by day-of-month.
	$events = array(
		3  => array( array( '9:00', 'Product launch 🎉', 'x' ) ),
		8  => array(
			array( '12:30', 'Behind the scenes', 'instagram' ),
			array( '17:00', 'Hiring: designer', 'linkedin' ),
		),
		15 => array( array( '10:00', 'Weekly tips thread', 'x' ) ),
		22 => array( array( '14:00', 'AMA announcement', 'x' ) ),
		24 => array( array( '11:00', 'New reel', 'instagram' ) ),
	);

	$weekdays = array( 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' );
	?>
	<div class="wrap mode-screen">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Calendar', 'mode' ); ?></h1>
		<a href="<?php echo esc_url( mode_social_url( 'composer' ) ); ?>" class="page-title-action"><?php esc_html_e( 'New post', 'mode' ); ?></a>
		<hr class="wp-header-end" />

		<div class="mode-card">
			<div class="mode-card__head mode-cal__head">
				<span><?php esc_html_e( 'April 2026', 'mode' ); ?></span>
				<span class="mode-cal__nav">
					<button type="button" class="button button-small">‹</button>
					<button type="button" class="button button-small"><?php esc_html_e( 'Today', 'mode' ); ?></button>
					<button type="button" class="button button-small">›</button>
				</span>
			</div>
			<div class="mode-cal">
				<?php foreach ( $weekdays as $wd ) : ?>
					<div class="mode-cal__weekday"><?php echo esc_html( $wd ); ?></div>
				<?php endforeach; ?>

				<?php for ( $i = 0; $i < $offset; $i++ ) : ?>
					<div class="mode-cal__day is-empty"></div>
				<?php endfor; ?>

				<?php for ( $d = 1; $d <= $days; $d++ ) : ?>
					<div class="mode-cal__day">
						<span class="mode-cal__date"><?php echo (int) $d; ?></span>
						<?php if ( isset( $events[ $d ] ) ) : ?>
							<?php foreach ( $events[ $d ] as $ev ) : ?>
								<span class="mode-cal__event">
									<?php echo mode_social_dot( $ev[2] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									<span class="mode-cal__event-text"><?php echo esc_html( $ev[0] . ' ' . $ev[1] ); ?></span>
								</span>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Render the Social → Accounts screen.
 *
 * @return void
 */
function mode_social_screen_accounts() {
	$nets = mode_social_networks();

	// key, handle, followers, status, variant.
	$accounts = array(
		array( 'x', '@themodeshow', '24.3K', 'Connected', 'connected' ),
		array( 'instagram', '@themodeshow', '18.1K', 'Connected', 'connected' ),
		array( 'linkedin', 'Mode', '9.4K', 'Connected', 'connected' ),
		array( 'facebook', 'Mode', '12.7K', 'Reconnect needed', 'pending' ),
		array( 'mastodon', '@mode@indieweb.social', '2.2K', 'Connected', 'connected' ),
		array( 'tiktok', '—', '—', 'Not connected', 'disconnected' ),
	);
	?>
	<div class="wrap mode-screen">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Accounts', 'mode' ); ?></h1>
		<a href="#" class="page-title-action"><?php esc_html_e( 'Connect account', 'mode' ); ?></a>
		<hr class="wp-header-end" />

		<div class="mode-card">
			<?php
			foreach ( $accounts as $acct ) :
				$net = $nets[ $acct[0] ];
				?>
				<div class="mode-platform">
					<span class="mode-platform__icon" style="background: <?php echo esc_attr( $net[2] ); ?>">
						<span class="dashicons <?php echo esc_attr( $net[1] ); ?>" style="color:#fff;"></span>
					</span>
					<div class="mode-platform__text">
						<div class="mode-platform__name"><?php echo esc_html( $net[0] ); ?></div>
						<div class="mode-platform__meta"><?php echo esc_html( $acct[1] ); ?><?php echo '—' !== $acct[2] ? ' · ' . esc_html( $acct[2] ) . ' ' . esc_html__( 'followers', 'mode' ) : ''; ?></div>
					</div>
					<?php echo mode_badge( $acct[3], $acct[4] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php if ( 'connected' === $acct[4] ) : ?>
						<a href="#" class="button"><?php esc_html_e( 'Manage', 'mode' ); ?></a>
					<?php elseif ( 'pending' === $acct[4] ) : ?>
						<a href="#" class="button button-primary"><?php esc_html_e( 'Reconnect', 'mode' ); ?></a>
					<?php else : ?>
						<a href="#" class="button button-primary"><?php esc_html_e( 'Connect', 'mode' ); ?></a>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

/**
 * Render the Social → Dashboard screen.
 *
 * @return void
 */
function mode_social_screen_dashboard() {
	$stats = array(
		array( 'Followers', '66,700', '+2.4%', 'up' ),
		array( 'Impressions', '1.2M', '+8.7%', 'up' ),
		array( 'Engagement rate', '4.8%', '+0.5%', 'up' ),
		array( 'Posts this month', '31', '', '' ),
	);

	$bars = array( 40, 52, 47, 58, 64, 61, 70, 66, 74, 80, 77, 86 );

	$top = array(
		array( 'Big news — Mode 1.0 is here. 🚀', 'x', '184K', '7.9K' ),
		array( 'Behind the scenes of the launch', 'instagram', '92K', '6.1K' ),
		array( "We're hiring a product designer", 'linkedin', '54K', '2.3K' ),
		array( 'Weekly tips: focused workflows', 'x', '47K', '1.8K' ),
	);

	$by_net = array(
		array( 'x', 'X', 42 ),
		array( 'instagram', 'Instagram', 33 ),
		array( 'linkedin', 'LinkedIn', 16 ),
		array( 'facebook', 'Facebook', 9 ),
	);

	$nets = mode_social_networks();
	?>
	<div class="wrap mode-screen">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Dashboard', 'mode' ); ?></h1>
		<a href="<?php echo esc_url( mode_social_url( 'composer' ) ); ?>" class="page-title-action"><?php esc_html_e( 'New post', 'mode' ); ?></a>
		<hr class="wp-header-end" />

		<div class="mode-stats">
			<?php foreach ( $stats as $stat ) : ?>
				<div class="mode-stat">
					<p class="mode-stat__label"><?php echo esc_html( $stat[0] ); ?></p>
					<div class="mode-stat__value"><?php echo esc_html( $stat[1] ); ?></div>
					<?php if ( $stat[2] ) : ?>
						<span class="mode-stat__delta is-<?php echo esc_attr( $stat[3] ); ?>"><?php echo esc_html( $stat[2] ); ?></span>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="mode-cols">
			<div class="mode-col">
				<div class="mode-card">
					<div class="mode-card__head"><?php esc_html_e( 'Engagement over time', 'mode' ); ?></div>
					<div class="mode-card__body">
						<div class="mode-bars" aria-hidden="true">
							<?php foreach ( $bars as $h ) : ?>
								<span style="height: <?php echo (int) $h; ?>%"></span>
							<?php endforeach; ?>
						</div>
						<p class="description" style="margin-top:12px;"><?php esc_html_e( 'Last 12 weeks — up 38% over the period.', 'mode' ); ?></p>
					</div>
				</div>

				<div class="mode-card">
					<div class="mode-card__head"><?php esc_html_e( 'Top posts', 'mode' ); ?></div>
					<table class="wp-list-table widefat striped mode-card__table">
						<thead>
							<tr>
								<th scope="col"><?php esc_html_e( 'Post', 'mode' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Network', 'mode' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Impressions', 'mode' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Engagements', 'mode' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $top as $row ) : ?>
								<tr>
									<td><strong><?php echo esc_html( $row[0] ); ?></strong></td>
									<td><?php echo mode_social_dot( $row[1] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php echo esc_html( $nets[ $row[1] ][0] ); ?></td>
									<td><?php echo esc_html( $row[2] ); ?></td>
									<td><?php echo esc_html( $row[3] ); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="mode-col">
				<div class="mode-card">
					<div class="mode-card__head"><?php esc_html_e( 'Audience by network', 'mode' ); ?></div>
					<div class="mode-card__body">
						<?php foreach ( $by_net as $row ) : ?>
							<div class="mode-meter">
								<div class="mode-meter__row"><span><?php echo mode_social_dot( $row[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php echo esc_html( $row[1] ); ?></span><span><?php echo (int) $row[2]; ?>%</span></div>
								<div class="mode-meter__track"><div class="mode-meter__fill" style="width: <?php echo (int) $row[2]; ?>%"></div></div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
