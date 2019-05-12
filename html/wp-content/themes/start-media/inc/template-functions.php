<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package start-media
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function start_media_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'start_media_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function start_media_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'start_media_pingback_header' );

/**
 * the_archive_titleから余計な文字を削る
 */
add_filter( 'get_the_archive_title', function ($title) {
  if ( is_category() ) {
    $title = single_cat_title( '', false );
  } elseif ( is_tag() ) {
    $title = single_tag_title( '', false );
	} elseif ( is_post_type_archive() ){
		$title = post_type_archive_title('', false );
	}
  return $title;
});

/**
 * ページネーション
 */
function pagination( $pages = 1, $range = 2, $show_only = false ) {

  $pages = (int) $pages;    //float型で渡ってくるので明示的に int型 へ
  $paged = get_query_var('paged') ? get_query_var('paged') : 1;

  //表示テキスト
  $text_first   = "最初へ";
  $text_last    = "最後へ";

  if ( $show_only && $pages === 1 ) {
    // １ページのみで表示設定が true の時
    echo '<div class="c-pagination"><span class="current">1</span></div>';
    return;
  }

  if ( $pages === 1 ) return;    // １ページのみで表示設定もない場合

  if ( 1 !== $pages ) {
    //２ページ以上の時
    echo '<div class="c-pagination">', "\n";
    echo '<div class="c-pagination__links">', "\n";
    if ( $paged > $range + 1 ) {
      // 「最初へ」 の表示
      echo '<a class="c-paginationLink" href="', get_pagenum_link(1) ,'">', $text_first ,'</a>';
    }
    for ( $i = 1; $i <= $pages; $i++ ) {
      if ( $i <= $paged + $range && $i >= $paged - $range ) {
        // $paged +- $range 以内であればページ番号を出力
        if ( $paged === $i ) {
           echo '<span class="c-paginationLink c-paginationLink--current">', $i ,'</span>';
        } else {
           echo '<a class="c-paginationLink" href="', get_pagenum_link( $i ) ,'" class="inactive">', $i ,'</a>';
        }
      }
    }
    if ( $paged + $range < $pages ) {
      // 「最後へ」 の表示
      echo '<a class="c-paginationLink" href="', get_pagenum_link( $pages ) ,'">', $text_last ,'</a>';
    }
    echo '</div>', "\n";
    echo '<div class="c-pagination__index"> ', $paged ,' / ', $pages , ' ページ' , '</div>', "\n";
    echo '</div>', "\n";
  }
}
