<?php
/**
 * Static mock screens for the Podcast mode.
 *
 * Hard-coded sample data rendered with core admin components plus the shared
 * `.mode-*` styles. A clickable preview only — nothing is saved.
 *
 * @package Mode
 */

defined( 'ABSPATH' ) || exit;

/**
 * URL to another Podcast screen, for in-prototype navigation.
 *
 * @param string $screen Screen slug.
 * @return string
 */
function mode_pod_url( $screen ) {
	$mode = mode_get( 'podcast' );

	return $mode ? Mode_Space::screen_url( $mode, $screen ) : '#';
}

/**
 * Render the Podcast → Episodes screen.
 *
 * @return void
 */
function mode_podcast_screen_episodes() {
	$episodes = array(
		array( '42', 'The future of audio', 'Published', 'sent', '52:10', '9,820', 'Apr 17, 2026' ),
		array( '41', 'Building in public', 'Published', 'sent', '47:35', '8,440', 'Apr 10, 2026' ),
		array( '43', 'Live Q&A special', 'Scheduled', 'scheduled', '—', '—', 'Apr 24, 2026' ),
		array( '40', 'Designing for sound', 'Published', 'sent', '39:02', '7,910', 'Apr 3, 2026' ),
		array( '—', 'Season 3 teaser', 'Draft', 'draft', '—', '—', '—' ),
		array( '39', 'Interview: Ada Lovelace', 'Published', 'sent', '58:20', '7,160', 'Mar 27, 2026' ),
	);
	?>
	<div class="wrap mode-screen">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Episodes', 'mode' ); ?></h1>
		<a href="<?php echo esc_url( mode_pod_url( 'recording' ) ); ?>" class="page-title-action"><?php esc_html_e( 'New episode', 'mode' ); ?></a>
		<hr class="wp-header-end" />

		<ul class="subsubsub">
			<li class="all"><a href="#" class="current"><?php esc_html_e( 'All', 'mode' ); ?> <span class="count">(43)</span></a> |</li>
			<li><a href="#"><?php esc_html_e( 'Published', 'mode' ); ?> <span class="count">(40)</span></a> |</li>
			<li><a href="#"><?php esc_html_e( 'Scheduled', 'mode' ); ?> <span class="count">(1)</span></a> |</li>
			<li><a href="#"><?php esc_html_e( 'Drafts', 'mode' ); ?> <span class="count">(2)</span></a></li>
		</ul>

		<table class="wp-list-table widefat fixed striped table-view-list">
			<thead>
				<tr>
					<td class="manage-column column-cb check-column"><input type="checkbox" /></td>
					<th scope="col" class="manage-column column-primary"><?php esc_html_e( 'Episode', 'mode' ); ?></th>
					<th scope="col" class="manage-column"><?php esc_html_e( 'Status', 'mode' ); ?></th>
					<th scope="col" class="manage-column"><?php esc_html_e( 'Duration', 'mode' ); ?></th>
					<th scope="col" class="manage-column"><?php esc_html_e( 'Downloads', 'mode' ); ?></th>
					<th scope="col" class="manage-column"><?php esc_html_e( 'Date', 'mode' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $episodes as $ep ) : ?>
					<tr>
						<th scope="row" class="check-column"><input type="checkbox" /></th>
						<td class="column-primary">
							<strong><a href="#"><?php echo esc_html( $ep[1] ); ?></a></strong>
							<?php if ( '—' !== $ep[0] ) : ?>
								<span class="mode-muted"><?php printf( esc_html__( 'Episode %s', 'mode' ), esc_html( $ep[0] ) ); ?></span>
							<?php endif; ?>
						</td>
						<td><?php echo mode_badge( $ep[2], $ep[3] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
						<td><?php echo esc_html( $ep[4] ); ?></td>
						<td><?php echo esc_html( $ep[5] ); ?></td>
						<td><?php echo esc_html( $ep[6] ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php
}

/**
 * Render the Podcast → Recording screen.
 *
 * @return void
 */
function mode_podcast_screen_recording() {
	$wave    = array( 18, 32, 48, 64, 40, 72, 56, 84, 60, 44, 76, 52, 30, 66, 88, 50, 38, 70, 46, 58, 34, 62, 80, 42, 26, 54, 68, 36, 74, 48 );
	$recents = array(
		array( 'Episode 42 — final mix', '52:10', 'Apr 16, 2026' ),
		array( 'Interview with Grace Hopper', '1:04:22', 'Apr 14, 2026' ),
		array( 'Cold open take 3', '02:48', 'Apr 14, 2026' ),
	);
	?>
	<div class="wrap mode-screen">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Recording', 'mode' ); ?></h1>
		<a href="#" class="page-title-action"><?php esc_html_e( 'Upload audio', 'mode' ); ?></a>
		<hr class="wp-header-end" />

		<div class="mode-cols">
			<div class="mode-col">
				<div class="mode-card">
					<div class="mode-card__body">
						<div class="mode-rec">
							<button type="button" class="mode-rec__btn" aria-label="<?php esc_attr_e( 'Start recording', 'mode' ); ?>"><span class="dashicons dashicons-microphone"></span></button>
							<div class="mode-rec__timer">00:00</div>
							<div class="mode-wave" aria-hidden="true">
								<?php foreach ( $wave as $h ) : ?>
									<span style="height: <?php echo (int) $h; ?>%"></span>
								<?php endforeach; ?>
							</div>
							<p class="description"><?php esc_html_e( 'Tap the mic to start recording, or upload an existing audio file.', 'mode' ); ?></p>
						</div>
					</div>
				</div>

				<div class="mode-card">
					<div class="mode-card__head"><?php esc_html_e( 'Recent recordings', 'mode' ); ?></div>
					<table class="wp-list-table widefat striped mode-card__table">
						<thead>
							<tr>
								<th scope="col"><?php esc_html_e( 'Name', 'mode' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Length', 'mode' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Recorded', 'mode' ); ?></th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $recents as $rec ) : ?>
								<tr>
									<td><strong><?php echo esc_html( $rec[0] ); ?></strong></td>
									<td><?php echo esc_html( $rec[1] ); ?></td>
									<td><?php echo esc_html( $rec[2] ); ?></td>
									<td><a href="#" class="button button-small"><?php esc_html_e( 'Use', 'mode' ); ?></a></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="mode-col">
				<div class="mode-card">
					<div class="mode-card__head"><?php esc_html_e( 'Episode details', 'mode' ); ?></div>
					<div class="mode-card__body">
						<p>
							<label class="mode-field-label" for="mode-pod-title"><?php esc_html_e( 'Title', 'mode' ); ?></label>
							<input type="text" id="mode-pod-title" class="widefat" value="Episode 43 — Live Q&amp;A special" />
						</p>
						<p>
							<label class="mode-field-label" for="mode-pod-season"><?php esc_html_e( 'Season / Episode', 'mode' ); ?></label>
							<input type="text" id="mode-pod-season" class="widefat" value="S3 · E43" />
						</p>
						<button type="button" class="button button-primary"><?php esc_html_e( 'Save draft', 'mode' ); ?></button>
					</div>
				</div>

				<div class="mode-card">
					<div class="mode-card__head"><?php esc_html_e( 'Recording tips', 'mode' ); ?></div>
					<div class="mode-card__body">
						<ul class="mode-checklist">
							<li><?php esc_html_e( 'Record in a quiet, soft-furnished room.', 'mode' ); ?></li>
							<li><?php esc_html_e( 'Keep the mic a hand-width from your mouth.', 'mode' ); ?></li>
							<li><?php esc_html_e( 'Do a 10-second test before the full take.', 'mode' ); ?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Render the Podcast → Distribution screen.
 *
 * @return void
 */
function mode_podcast_screen_distribution() {
	$platforms = array(
		array( 'Apple Podcasts', 'Connected', 'connected', 'dashicons-microphone' ),
		array( 'Spotify', 'Connected', 'connected', 'dashicons-format-audio' ),
		array( 'YouTube', 'Connected', 'connected', 'dashicons-video-alt3' ),
		array( 'Amazon Music', 'Not connected', 'disconnected', 'dashicons-cart' ),
		array( 'Overcast', 'Not connected', 'disconnected', 'dashicons-cloud' ),
	);
	?>
	<div class="wrap mode-screen">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Distribution', 'mode' ); ?></h1>
		<hr class="wp-header-end" />

		<div class="mode-cols">
			<div class="mode-col">
				<div class="mode-card">
					<div class="mode-card__head"><?php esc_html_e( 'Platforms', 'mode' ); ?></div>
					<?php foreach ( $platforms as $p ) : ?>
						<div class="mode-platform">
							<span class="mode-platform__icon"><span class="dashicons <?php echo esc_attr( $p[3] ); ?>"></span></span>
							<div class="mode-platform__text">
								<div class="mode-platform__name"><?php echo esc_html( $p[0] ); ?></div>
								<div class="mode-platform__meta"><?php echo esc_html( $p[1] ); ?></div>
							</div>
							<?php if ( 'connected' === $p[2] ) : ?>
								<a href="#" class="button"><?php esc_html_e( 'Manage', 'mode' ); ?></a>
							<?php else : ?>
								<a href="#" class="button button-primary"><?php esc_html_e( 'Connect', 'mode' ); ?></a>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="mode-col">
				<div class="mode-card">
					<div class="mode-card__head"><?php esc_html_e( 'Your RSS feed', 'mode' ); ?></div>
					<div class="mode-card__body">
						<p class="description" style="margin-top:0;"><?php esc_html_e( 'Submit this feed to any platform not listed.', 'mode' ); ?></p>
						<input type="text" class="widefat code" readonly value="https://feeds.modewp.com/the-mode-show.xml" onfocus="this.select();" />
						<p><button type="button" class="button"><?php esc_html_e( 'Copy feed URL', 'mode' ); ?></button></p>
					</div>
				</div>

				<div class="mode-card">
					<div class="mode-card__head"><?php esc_html_e( 'Checklist', 'mode' ); ?></div>
					<div class="mode-card__body">
						<ul class="mode-checklist">
							<li><?php esc_html_e( 'Cover art is 3000 × 3000px.', 'mode' ); ?></li>
							<li><?php esc_html_e( 'Show description is filled in.', 'mode' ); ?></li>
							<li><?php esc_html_e( 'Category set to Technology.', 'mode' ); ?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Render the Podcast → Dashboard screen.
 *
 * @return void
 */
function mode_podcast_screen_dashboard() {
	$stats = array(
		array( 'Total downloads', '248,391', '+5.4%', 'up' ),
		array( 'Avg. per episode', '6,210', '+2.1%', 'up' ),
		array( 'Followers', '8,930', '+1.8%', 'up' ),
		array( 'Completion rate', '72%', '-0.6%', 'down' ),
	);

	$bars = array( 42, 48, 45, 53, 60, 57, 66, 72, 69, 78, 84, 91 );

	$top = array(
		array( 'Ep 42 — The future of audio', '9,820', '78%' ),
		array( 'Ep 41 — Building in public', '8,440', '74%' ),
		array( 'Ep 40 — Designing for sound', '7,910', '71%' ),
		array( 'Ep 39 — Interview: Ada Lovelace', '7,160', '69%' ),
		array( 'Ep 38 — Tooling deep dive', '6,540', '66%' ),
	);

	$platforms = array(
		array( 'Apple Podcasts', 46 ),
		array( 'Spotify', 38 ),
		array( 'YouTube', 9 ),
		array( 'Other', 7 ),
	);
	?>
	<div class="wrap mode-screen">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Dashboard', 'mode' ); ?></h1>
		<a href="<?php echo esc_url( mode_pod_url( 'recording' ) ); ?>" class="page-title-action"><?php esc_html_e( 'New episode', 'mode' ); ?></a>
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
					<div class="mode-card__head"><?php esc_html_e( 'Downloads over time', 'mode' ); ?></div>
					<div class="mode-card__body">
						<div class="mode-bars" aria-hidden="true">
							<?php foreach ( $bars as $h ) : ?>
								<span style="height: <?php echo (int) $h; ?>%"></span>
							<?php endforeach; ?>
						</div>
						<p class="description" style="margin-top:12px;"><?php esc_html_e( 'Last 12 weeks — up 47% over the period.', 'mode' ); ?></p>
					</div>
				</div>

				<div class="mode-card">
					<div class="mode-card__head"><?php esc_html_e( 'Top episodes', 'mode' ); ?></div>
					<table class="wp-list-table widefat striped mode-card__table">
						<thead>
							<tr>
								<th scope="col"><?php esc_html_e( 'Episode', 'mode' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Downloads', 'mode' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Completion', 'mode' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $top as $row ) : ?>
								<tr>
									<td><strong><?php echo esc_html( $row[0] ); ?></strong></td>
									<td><?php echo esc_html( $row[1] ); ?></td>
									<td><?php echo esc_html( $row[2] ); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="mode-col">
				<div class="mode-card">
					<div class="mode-card__head"><?php esc_html_e( 'Listeners by platform', 'mode' ); ?></div>
					<div class="mode-card__body">
						<?php foreach ( $platforms as $p ) : ?>
							<div class="mode-meter">
								<div class="mode-meter__row"><span><?php echo esc_html( $p[0] ); ?></span><span><?php echo (int) $p[1]; ?>%</span></div>
								<div class="mode-meter__track"><div class="mode-meter__fill" style="width: <?php echo (int) $p[1]; ?>%"></div></div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
