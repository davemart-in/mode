<?php
/**
 * Static mock screens for the Newsletter mode.
 *
 * Everything here is hard-coded sample data — the goal is a believable,
 * clickable preview built from core admin components (list tables, cards,
 * buttons, notices) so it reads as native wp-admin. No real data or saving.
 *
 * @package Mode
 */

defined( 'ABSPATH' ) || exit;

/**
 * URL to another Newsletter screen, for in-prototype navigation.
 *
 * @param string $screen Screen slug.
 * @return string
 */
function mode_news_url( $screen ) {
	$mode = mode_get( 'newsletter' );

	return $mode ? Mode_Space::screen_url( $mode, $screen ) : '#';
}

/**
 * A small status pill.
 *
 * @param string $label   Visible text.
 * @param string $variant One of: sent, scheduled, draft, active, pending, unsub.
 * @return string HTML.
 */
function mode_news_badge( $label, $variant ) {
	return sprintf(
		'<span class="mode-badge mode-badge--%s">%s</span>',
		esc_attr( $variant ),
		esc_html( $label )
	);
}

/**
 * Render the Newsletter → Dashboard screen.
 *
 * @return void
 */
function mode_newsletter_screen_dashboard() {
	$stats = array(
		array( 'Subscribers', '12,847', '+3.2%', 'up' ),
		array( 'Avg. open rate', '48.6%', '+1.4%', 'up' ),
		array( 'Avg. click rate', '7.1%', '-0.3%', 'down' ),
		array( 'Sent this month', '9', '', '' ),
	);

	$recent = array(
		array( 'April product update', 'Sent', 'sent', '12,540', '49.2%', 'Apr 18' ),
		array( 'Spring sale starts now', 'Sent', 'sent', '12,318', '52.7%', 'Apr 11' ),
		array( 'New: dark mode', 'Sent', 'sent', '12,090', '47.1%', 'Apr 4' ),
		array( 'March recap', 'Sent', 'sent', '11,902', '45.8%', 'Mar 28' ),
		array( 'Welcome series #3', 'Automated', 'active', '1,204', '61.0%', 'Ongoing' ),
	);

	$bars = array( 38, 44, 41, 52, 58, 63, 71 );
	?>
	<div class="wrap mode-screen">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Dashboard', 'mode' ); ?></h1>
		<a href="<?php echo esc_url( mode_news_url( 'broadcasts' ) ); ?>" class="page-title-action"><?php esc_html_e( 'New broadcast', 'mode' ); ?></a>
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
					<div class="mode-card__head"><?php esc_html_e( 'Recent broadcasts', 'mode' ); ?></div>
					<table class="wp-list-table widefat striped mode-card__table">
						<thead>
							<tr>
								<th scope="col"><?php esc_html_e( 'Subject', 'mode' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Status', 'mode' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Recipients', 'mode' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Opens', 'mode' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Sent', 'mode' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $recent as $row ) : ?>
								<tr>
									<td><strong><a href="<?php echo esc_url( mode_news_url( 'broadcasts' ) ); ?>"><?php echo esc_html( $row[0] ); ?></a></strong></td>
									<td><?php echo mode_news_badge( $row[1], $row[2] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
									<td><?php echo esc_html( $row[3] ); ?></td>
									<td><?php echo esc_html( $row[4] ); ?></td>
									<td><?php echo esc_html( $row[5] ); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="mode-col">
				<div class="mode-card">
					<div class="mode-card__head"><?php esc_html_e( 'Audience growth', 'mode' ); ?></div>
					<div class="mode-card__body">
						<div class="mode-bars" aria-hidden="true">
							<?php foreach ( $bars as $h ) : ?>
								<span style="height: <?php echo (int) $h; ?>%"></span>
							<?php endforeach; ?>
						</div>
						<p class="description" style="margin-top: 12px;"><?php esc_html_e( '+1,142 subscribers in the last 7 weeks.', 'mode' ); ?></p>
					</div>
				</div>

				<div class="mode-card">
					<div class="mode-card__head"><?php esc_html_e( 'Quick actions', 'mode' ); ?></div>
					<div class="mode-card__body mode-actions">
						<a href="<?php echo esc_url( mode_news_url( 'broadcasts' ) ); ?>" class="button button-primary"><?php esc_html_e( 'New broadcast', 'mode' ); ?></a>
						<a href="<?php echo esc_url( mode_news_url( 'subscribers' ) ); ?>" class="button"><?php esc_html_e( 'Import subscribers', 'mode' ); ?></a>
						<a href="<?php echo esc_url( mode_news_url( 'templates' ) ); ?>" class="button"><?php esc_html_e( 'Edit templates', 'mode' ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Render the Newsletter → Subscribers screen.
 *
 * @return void
 */
function mode_newsletter_screen_subscribers() {
	$subscribers = array(
		array( 'ada@example.com', 'Ada Lovelace', 'Active', 'active', 'Apr 2, 2026', 'Weekly' ),
		array( 'grace@example.com', 'Grace Hopper', 'Active', 'active', 'Mar 28, 2026', 'Weekly, Product' ),
		array( 'alan@example.com', 'Alan Turing', 'Active', 'active', 'Mar 21, 2026', 'Weekly' ),
		array( 'katherine@example.com', 'Katherine Johnson', 'Active', 'active', 'Mar 15, 2026', 'Product' ),
		array( 'margaret@example.com', 'Margaret Hamilton', 'Active', 'active', 'Jan 30, 2026', 'Weekly' ),
		array( 'tim@example.com', 'Tim Berners-Lee', 'Active', 'active', 'Jan 12, 2026', 'Weekly, Product' ),
		array( 'radia@example.com', 'Radia Perlman', 'Pending', 'pending', 'Jan 5, 2026', 'Weekly' ),
		array( 'linus@example.com', 'Linus Torvalds', 'Unsubscribed', 'unsub', 'Feb 2, 2026', '—' ),
	);
	?>
	<div class="wrap mode-screen">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Subscribers', 'mode' ); ?></h1>
		<a href="#" class="page-title-action"><?php esc_html_e( 'Add subscriber', 'mode' ); ?></a>
		<hr class="wp-header-end" />

		<ul class="subsubsub">
			<li class="all"><a href="#" class="current"><?php esc_html_e( 'All', 'mode' ); ?> <span class="count">(12,847)</span></a> |</li>
			<li><a href="#"><?php esc_html_e( 'Active', 'mode' ); ?> <span class="count">(12,102)</span></a> |</li>
			<li><a href="#"><?php esc_html_e( 'Pending', 'mode' ); ?> <span class="count">(745)</span></a> |</li>
			<li><a href="#"><?php esc_html_e( 'Unsubscribed', 'mode' ); ?> <span class="count">(745)</span></a></li>
		</ul>

		<p class="search-box">
			<label class="screen-reader-text" for="mode-news-search"><?php esc_html_e( 'Search Subscribers', 'mode' ); ?></label>
			<input type="search" id="mode-news-search" value="" />
			<button type="button" class="button"><?php esc_html_e( 'Search Subscribers', 'mode' ); ?></button>
		</p>

		<div class="tablenav top">
			<div class="alignleft actions bulkactions">
				<select>
					<option><?php esc_html_e( 'Bulk actions', 'mode' ); ?></option>
					<option><?php esc_html_e( 'Add to list', 'mode' ); ?></option>
					<option><?php esc_html_e( 'Unsubscribe', 'mode' ); ?></option>
					<option><?php esc_html_e( 'Delete', 'mode' ); ?></option>
				</select>
				<button type="button" class="button action"><?php esc_html_e( 'Apply', 'mode' ); ?></button>
			</div>
			<div class="tablenav-pages">
				<span class="displaying-num"><?php esc_html_e( '12,847 items', 'mode' ); ?></span>
				<span class="pagination-links">
					<span class="tablenav-pages-navspan button disabled" aria-hidden="true">‹</span>
					<span class="screen-reader-text"><?php esc_html_e( 'Current Page', 'mode' ); ?></span>
					<span class="paging-input"><span class="tablenav-paging-text">1 <?php esc_html_e( 'of', 'mode' ); ?> <span class="total-pages">1,606</span></span></span>
					<a class="next-page button" href="#">›</a>
				</span>
			</div>
		</div>

		<table class="wp-list-table widefat fixed striped table-view-list">
			<thead>
				<tr>
					<td class="manage-column column-cb check-column"><input type="checkbox" /></td>
					<th scope="col" class="manage-column column-primary"><?php esc_html_e( 'Email', 'mode' ); ?></th>
					<th scope="col" class="manage-column"><?php esc_html_e( 'Name', 'mode' ); ?></th>
					<th scope="col" class="manage-column"><?php esc_html_e( 'Status', 'mode' ); ?></th>
					<th scope="col" class="manage-column"><?php esc_html_e( 'Subscribed', 'mode' ); ?></th>
					<th scope="col" class="manage-column"><?php esc_html_e( 'Lists', 'mode' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $subscribers as $sub ) : ?>
					<tr>
						<th scope="row" class="check-column"><input type="checkbox" /></th>
						<td class="column-primary"><strong><a href="#"><?php echo esc_html( $sub[0] ); ?></a></strong></td>
						<td><?php echo esc_html( $sub[1] ); ?></td>
						<td><?php echo mode_news_badge( $sub[2], $sub[3] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
						<td><?php echo esc_html( $sub[4] ); ?></td>
						<td><?php echo esc_html( $sub[5] ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php
}

/**
 * Render the Newsletter → Broadcasts screen.
 *
 * @return void
 */
function mode_newsletter_screen_broadcasts() {
	$broadcasts = array(
		array( 'April product update', 'Sent', 'sent', '12,540', '49.2%', '8.1%', 'Apr 18, 2026' ),
		array( 'Spring sale starts now', 'Sent', 'sent', '12,318', '52.7%', '11.3%', 'Apr 11, 2026' ),
		array( 'May feature preview', 'Scheduled', 'scheduled', '—', '—', '—', 'Apr 30, 2026' ),
		array( 'Customer stories vol. 2', 'Draft', 'draft', '—', '—', '—', '—' ),
		array( 'New: dark mode', 'Sent', 'sent', '12,090', '47.1%', '6.9%', 'Apr 4, 2026' ),
		array( 'Mid-month tips', 'Draft', 'draft', '—', '—', '—', '—' ),
	);
	?>
	<div class="wrap mode-screen">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Broadcasts', 'mode' ); ?></h1>
		<a href="#" class="page-title-action"><?php esc_html_e( 'New broadcast', 'mode' ); ?></a>
		<hr class="wp-header-end" />

		<ul class="subsubsub">
			<li class="all"><a href="#" class="current"><?php esc_html_e( 'All', 'mode' ); ?> <span class="count">(24)</span></a> |</li>
			<li><a href="#"><?php esc_html_e( 'Sent', 'mode' ); ?> <span class="count">(18)</span></a> |</li>
			<li><a href="#"><?php esc_html_e( 'Scheduled', 'mode' ); ?> <span class="count">(2)</span></a> |</li>
			<li><a href="#"><?php esc_html_e( 'Drafts', 'mode' ); ?> <span class="count">(4)</span></a></li>
		</ul>

		<table class="wp-list-table widefat fixed striped table-view-list">
			<thead>
				<tr>
					<th scope="col" class="manage-column column-primary"><?php esc_html_e( 'Subject', 'mode' ); ?></th>
					<th scope="col" class="manage-column"><?php esc_html_e( 'Status', 'mode' ); ?></th>
					<th scope="col" class="manage-column"><?php esc_html_e( 'Recipients', 'mode' ); ?></th>
					<th scope="col" class="manage-column"><?php esc_html_e( 'Opens', 'mode' ); ?></th>
					<th scope="col" class="manage-column"><?php esc_html_e( 'Clicks', 'mode' ); ?></th>
					<th scope="col" class="manage-column"><?php esc_html_e( 'Date', 'mode' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $broadcasts as $b ) : ?>
					<tr>
						<td class="column-primary"><strong><a href="#"><?php echo esc_html( $b[0] ); ?></a></strong></td>
						<td><?php echo mode_news_badge( $b[1], $b[2] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
						<td><?php echo esc_html( $b[3] ); ?></td>
						<td><?php echo esc_html( $b[4] ); ?></td>
						<td><?php echo esc_html( $b[5] ); ?></td>
						<td><?php echo esc_html( $b[6] ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php
}

/**
 * Render the Newsletter → Templates screen.
 *
 * @return void
 */
function mode_newsletter_screen_templates() {
	$templates = array(
		array( 'Welcome email', 'Edited 3 days ago', 'dashicons-email' ),
		array( 'Weekly digest', 'Edited 1 week ago', 'dashicons-list-view' ),
		array( 'Product announcement', 'Edited 2 weeks ago', 'dashicons-megaphone' ),
		array( 'Promotion', 'Edited 1 month ago', 'dashicons-tag' ),
		array( 'Plain text', 'Edited 2 months ago', 'dashicons-text' ),
		array( 'Re-engagement', 'Edited 3 months ago', 'dashicons-update' ),
	);
	?>
	<div class="wrap mode-screen">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Templates', 'mode' ); ?></h1>
		<a href="#" class="page-title-action"><?php esc_html_e( 'New template', 'mode' ); ?></a>
		<hr class="wp-header-end" />

		<div class="mode-templates">
			<?php foreach ( $templates as $tpl ) : ?>
				<div class="mode-tpl">
					<div class="mode-tpl__thumb"><span class="dashicons <?php echo esc_attr( $tpl[2] ); ?>"></span></div>
					<div class="mode-tpl__body">
						<p class="mode-tpl__name"><?php echo esc_html( $tpl[0] ); ?></p>
						<p class="mode-tpl__meta"><?php echo esc_html( $tpl[1] ); ?></p>
						<a href="#" class="button button-primary"><?php esc_html_e( 'Edit', 'mode' ); ?></a>
						<a href="#" class="button"><?php esc_html_e( 'Preview', 'mode' ); ?></a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}
