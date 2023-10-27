<?php
namespace QuantumCloud\VoiceMessageAddon;

use DOMDocument;
use DOMElement;

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/**
 * SINGLETON: Class used to implement work with svg files.
 *
 * @since 1.0.0
 **/
final class SvgHelper {

	/**
	 * .svg extension MIME type.
	 *
	 * @const MIME_TYPE
	 * @since 1.0.0
	 **/
	const MIME_TYPE = 'image/svg+xml';

	const META_KEY = '_contacter_inline_svg';

	/**
	 * Regex to sanitize svg elements.
	 *
	 * @const SCRIPT_REGEX
	 * @since 1.0.0
	 **/
	const SCRIPT_REGEX = '/(?:\w+script|data):/xi';

	/**
	 * DomDocument instance for svg sanitization.
	 *
	 * @var DOMDocument
	 * @since 1.0.0
	 **/
	private $svg_dom = null;

	/**
	 * The one true SvgHelper.
	 *
	 * @var SvgHelper
	 * @since 1.0.0
	 **/
	private static $instance;

	/**
	 * Sets up a new SvgHelper instance.
	 *
	 * @since 1.0.0
	 * @access public
	 **/
	private function __construct() {

		/** List of allowed mime types and file extensions. */
		add_action( 'upload_mimes', [$this, 'upload_mimes'], 1, 1 );

		/** Filter data for the current file to upload. */
		add_filter( 'wp_handle_upload_prefilter', [ $this, 'wp_handle_upload_prefilter' ] );

		add_filter( 'wp_check_filetype_and_ext', [ $this, 'wp_check_filetype_and_ext' ], 10, 4 );
		add_filter( 'wp_prepare_attachment_for_js', [ $this, 'wp_prepare_attachment_for_js' ], 10, 3 );
	}

	/**
	 * Prepare svg Attachment
	 * @param $attachment_data
	 * @param $attachment
	 * @param $meta
	 *
	 * @since 1.0.0
	 * @access public
	 * @return mixed
	 **/
	public function wp_prepare_attachment_for_js( $attachment_data, $attachment, $meta ) {

		if ( 'image' !== $attachment_data['type'] || 'svg+xml' !== $attachment_data['subtype'] || ! class_exists( 'SimpleXMLElement' ) ) {
			return $attachment_data;
		}

		$svg = self::get_inline_svg( $attachment->ID );
		if ( ! $svg ) {
			return $attachment_data;
		}

		try {
			$svg = new \SimpleXMLElement( $svg );
		} catch ( \Exception $e ) {
			return $attachment_data;
		}

		$src = $attachment_data['url'];
		$width = (int) $svg['width'];
		$height = (int) $svg['height'];

		/** Media Gallery. */
		$attachment_data['image'] = compact( 'src', 'width', 'height' );
		$attachment_data['thumb'] = compact( 'src', 'width', 'height' );

		/** Single Details of Image. */
		$attachment_data['sizes']['full'] = [
			'height' => $height,
			'width' => $width,
			'url' => $src,
			'orientation' => $height > $width ? 'portrait' : 'landscape',
		];

		return $attachment_data;
	}

	/**
	 * Get inline svg.
	 * @param $attachment_id
	 *
	 * @since 1.0.0
	 * @access public
	 * @return bool|mixed|string
	 **/
	public static function get_inline_svg( $attachment_id ) {

		$svg = get_post_meta( $attachment_id, self::META_KEY, true );

		if ( ! empty( $svg ) ) {
			return $svg;
		}

		$svg = file_get_contents( get_attached_file( $attachment_id ) );

		if ( ! empty( $svg ) ) {
			update_post_meta( $attachment_id, self::META_KEY, $svg );
		}

		return $svg;
	}

	/**
	 * Check filetype and extension.
	 * A workaround for upload validation which relies on a PHP extension (fileinfo)
	 * with inconsistent reporting behaviour.
	 * ref: https://core.trac.wordpress.org/ticket/39550
	 * ref: https://core.trac.wordpress.org/ticket/40175
	 *
	 * @param $data
	 * @param $file
	 * @param $filename
	 * @param $mimes
	 *
	 * @since 1.0.0
	 * @access public
	 * @return mixed
	 **/
	public function wp_check_filetype_and_ext( $data, $file, $filename, $mimes ) {

		if ( ! empty( $data['ext'] ) && ! empty( $data['type'] ) ) {
			return $data;
		}

		$filetype = wp_check_filetype( $filename, $mimes );

		if ( 'svg' === $filetype['ext'] ) {
			$data['ext'] = 'svg';
			$data['type'] = self::MIME_TYPE;
		}

		return $data;
	}

	/**
	 * Filter data for the current file to upload.
	 *
	 * @param $file array - An array of data for a uploading file.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return mixed
	 **/
	public function wp_handle_upload_prefilter( $file ) {

		/** Exit if this is not our .svg file uploading. */
		if ( self::MIME_TYPE !== $file['type'] ) {
			return $file;
		}

		/** Get file extension. */
		$ext = pathinfo( $file['name'], PATHINFO_EXTENSION );

		/** Security checks. */
		/** Check file extension.  */
		if ( 'svg' !== $ext ) {
			$file['error'] = sprintf( esc_html__( 'The uploaded %s file is not supported. Please upload a valid SVG file', 'wpbotvoicemessage' ), $ext );
			return $file;
		}

		/** Can we upload and clean .svg files? */
		if ( ! self::is_enabled() ) {
			$file['error'] = esc_html__( 'SVG file is not allowed for security reasons', 'wpbotvoicemessage' );
			return $file;
		}

		/** Clean .svg file. */
		if ( self::svg_sanitizer_can_run() && ! $this->sanitize_svg( $file['tmp_name'] ) ) {
			$file['error'] = esc_html__( 'Invalid SVG Format, file not uploaded for security reasons', 'wpbotvoicemessage' );
		}

		return $file;
	}

	/**
	 *
	 *
	 * @param $filename string - Full temporary path to uploaded file.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return bool
	 **/
	public function sanitize_svg( $filename ) {

		/** Get svg file content. */
		$original_content = file_get_contents( $filename );
		$is_encoded = $this->is_encoded( $original_content );

		/** If content are gzipped. */
		if ( $is_encoded ) {
			$decoded = $this->decode_svg( $original_content );
			if ( false === $decoded ) {
				return false;
			}
			$original_content = $decoded;
		}

		$valid_svg = $this->sanitizer( $original_content );

		if ( false === $valid_svg ) {
			return false;
		}

		// If we were gzipped, we need to re-zip
		if ( $is_encoded ) {
			$valid_svg = $this->encode_svg( $valid_svg );
		}
		file_put_contents( $filename, $valid_svg );

		return true;
	}

	/**
	 * SVG Sanitizer.
	 *
	 * @param $content string - SVG file content.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return bool|string
	 **/
	public function sanitizer( $content ) {

		/** Strip php tags. */
		$content = $this->strip_php_tags( $content );

		/** Strip comments. */
		$content = $this->strip_comments( $content );

		/** Find the start and end tags. */
		$start = strpos( $content, '<svg' );
		$end = strrpos( $content, '</svg>' );

		if ( false === $start || false === $end ) {
			return false;
		}

		/** Remove miscellaneous garbage. */
		$content = substr( $content, $start, ( $end - $start + 6 ) );

		/** Make sure to Disable the ability to load external entities. */
		$libxml_disable_entity_loader = libxml_disable_entity_loader( true );

		/** Suppress the errors. */
		$libxml_use_internal_errors = libxml_use_internal_errors( true );

		/** Create DomDocument instance. */
		$this->svg_dom = new DOMDocument();
		$this->svg_dom->formatOutput = false;
		$this->svg_dom->preserveWhiteSpace = false;
		$this->svg_dom->strictErrorChecking = false;

		/** Load cleared svg content. */
		$open_svg = $this->svg_dom->loadXML( $content );
		if ( ! $open_svg ) {
			return false;
		}

		$this->strip_doctype();
		$this->sanitize_elements();

		/**
		 * Export sanitized svg to string.
		 * Using documentElement to strip out <?xml version="1.0" encoding="UTF-8"...
		 **/
		$sanitized = $this->svg_dom->saveXML( $this->svg_dom->documentElement, LIBXML_NOEMPTYTAG );

		/** Restore defaults. */
		libxml_disable_entity_loader( $libxml_disable_entity_loader );
		libxml_use_internal_errors( $libxml_use_internal_errors );

		return $sanitized;
	}

	/**
	 * Sanitize elements.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 **/
	private function sanitize_elements() {

		$elements = $this->svg_dom->getElementsByTagName( '*' );

		/**
		 * Loop through all elements
		 * we do this backwards so we don't skip anything if we delete a node
		 * @see http://php.net/manual/en/class.domnamednodemap.php
		 **/
		for ( $index = $elements->length - 1; $index >= 0; $index-- ) {

			/** @var DOMElement $current_element */
			$current_element = $elements->item( $index );

			/** If the tag isn't in the whitelist, remove it and continue with next iteration. */
			if ( ! $this->is_allowed_tag( $current_element ) ) {
				continue;
			}

			/** Validate element attributes. */
			$this->validate_allowed_attributes( $current_element );

			$this->strip_xlinks( $current_element );

			$href = $current_element->getAttribute( 'href' );
			if ( 1 === preg_match( self::SCRIPT_REGEX, $href ) ) {
				$current_element->removeAttribute( 'href' );
			}

			if ( 'use' === strtolower( $current_element->tagName ) ) {
				$this->validate_use_tag( $current_element );
			}
		}
	}

	/**
	 * Validate use tag
	 *
	 * @param $element
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 **/
	private function validate_use_tag( $element ) {
		$xlinks = $element->getAttributeNS( 'http://www.w3.org/1999/xlink', 'href' );

		if ( $xlinks && '#' !== substr( $xlinks, 0, 1 ) ) {
			$element->parentNode->removeChild( $element );
		}
	}

	/**
	 * Remove xlinks.
	 *
	 * @param DOMElement $element
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 **/
	private function strip_xlinks( $element ) {

		$xlinks = $element->getAttributeNS( 'http://www.w3.org/1999/xlink', 'href' );
		$allowed_links = [
			'data:image/png', // PNG
			'data:image/gif', // GIF
			'data:image/jpg', // JPG
			'data:image/jpe', // JPEG
			'data:image/pjp', // PJPEG
		];

		if ( 1 === preg_match( self::SCRIPT_REGEX, $xlinks ) ) {
			if ( ! in_array( substr( $xlinks, 0, 14 ), $allowed_links ) ) {
				$element->removeAttributeNS( 'http://www.w3.org/1999/xlink', 'href' );
			}
		}
	}

	/**
	 * Validate allowed attributes.
	 *
	 * @param DOMElement $element
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 **/
	private function validate_allowed_attributes( $element ) {
		static $allowed_attributes = false;

		/** Get allowed svg attributes. */
		if ( false === $allowed_attributes ) {
			$allowed_attributes = $this->get_allowed_attributes();
		}

		for ( $index = $element->attributes->length - 1; $index >= 0; $index-- ) {

			/** Get attribute name. */
			$attr_name = $element->attributes->item( $index )->name;
			$attr_name_lowercase = strtolower( $attr_name );

			/** Remove attribute if not in whitelist. */
			if ( ! in_array( $attr_name_lowercase, $allowed_attributes ) && ! $this->is_a_attribute( $attr_name_lowercase, 'aria' ) && ! $this->is_a_attribute( $attr_name_lowercase, 'data' ) ) {
				$element->removeAttribute( $attr_name );
				continue;
			}

			$attr_value = $element->attributes->item( $index )->value;

			/** Remove attribute if it has a remote reference or js. */
			if ( ! empty( $attr_value ) && ( $this->is_remote_value( $attr_value ) || $this->has_js_value( $attr_value ) ) ) {
				$element->removeAttribute( $attr_name );
				continue;
			}
		}
	}

	/**
	 * Has js value.
	 *
	 * @param $value
	 *
	 * @since  1.0.0
	 * @access private
	 * @return false|int
	 **/
	private function has_js_value( $value ) {
		return preg_match( '/(script|javascript|alert\(|window\.|document)/i', $value );
	}

	/**
	 * Is remote value.
	 *
	 * @param $value
	 *
	 * @since  1.0.0
	 * @access private
	 * @return string
	 **/
	private function is_remote_value( $value ) {
		$value = trim( preg_replace( '/[^ -~]/xu', '', $value ) );
		$wrapped_in_url = preg_match( '~^url\(\s*[\'"]\s*(.*)\s*[\'"]\s*\)$~xi', $value, $match );
		if ( ! $wrapped_in_url ) {
			return false;
		}

		$value = trim( $match[1], '\'"' );
		return preg_match( '~^((https?|ftp|file):)?//~xi', $value );
	}

	/**
	 * Is a attribute.
	 *
	 * @param $name
	 * @param $check
	 *
	 * @since  1.0.0
	 * @access private
	 * @return bool
	 **/
	private function is_a_attribute( $name, $check ) {
		return 0 === strpos( $name, $check . '-' );
	}

	/**
	 * Return array of allowed svg elments attributes.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return array
	 *
	 * @noinspection SpellCheckingInspection
	 **/
	private function get_allowed_attributes() {

		/** @noinspection PhpUnnecessaryLocalVariableInspection */
		$allowed_attributes = [
			'class',
			'clip-path',
			'clip-rule',
			'fill',
			'fill-opacity',
			'fill-rule',
			'filter',
			'id',
			'mask',
			'opacity',
			'stroke',
			'stroke-dasharray',
			'stroke-dashoffset',
			'stroke-linecap',
			'stroke-linejoin',
			'stroke-miterlimit',
			'stroke-opacity',
			'stroke-width',
			'style',
			'systemlanguage',
			'transform',
			'href',
			'xlink:href',
			'xlink:title',
			'cx',
			'cy',
			'r',
			'requiredfeatures',
			'clippathunits',
			'type',
			'rx',
			'ry',
			'color-interpolation-filters',
			'stddeviation',
			'filterres',
			'filterunits',
			'height',
			'primitiveunits',
			'width',
			'x',
			'y',
			'font-size',
			'display',
			'font-family',
			'font-style',
			'font-weight',
			'text-anchor',
			'marker-end',
			'marker-mid',
			'marker-start',
			'x1',
			'x2',
			'y1',
			'y2',
			'gradienttransform',
			'gradientunits',
			'spreadmethod',
			'markerheight',
			'markerunits',
			'markerwidth',
			'orient',
			'preserveaspectratio',
			'refx',
			'refy',
			'viewbox',
			'maskcontentunits',
			'maskunits',
			'd',
			'patterncontentunits',
			'patterntransform',
			'patternunits',
			'points',
			'fx',
			'fy',
			'offset',
			'stop-color',
			'stop-opacity',
			'xmlns',
			'xmlns:se',
			'xmlns:xlink',
			'xml:space',
			'method',
			'spacing',
			'startoffset',
			'dx',
			'dy',
			'rotate',
			'textlength',
		];

		return $allowed_attributes;
	}

	/**
	 * Is Allowed Tag.
	 *
	 * @param $element
	 *
	 * @since  1.0.0
	 * @access private
	 * @return bool
	 **/
	private function is_allowed_tag( $element ) {

		static $allowed_tags = false;

		if ( false === $allowed_tags ) {
			$allowed_tags = $this->get_allowed_elements();
		}

		$tag_name = $element->tagName;

		/** Remove unallowed element. */
		if ( ! in_array( strtolower( $tag_name ), $allowed_tags ) ) {
			$this->remove_element( $element );
			return false;
		}

		return true;
	}

	/**
	 * Remove element.
	 *
	 * @param $element
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 **/
	private function remove_element( $element ) {
		$element->parentNode->removeChild( $element );
	}

	/**
	 * Return array of allowed svg tags.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return array
	 *
	 * @noinspection SpellCheckingInspection
	 **/
	private function get_allowed_elements() {

		/** @noinspection PhpUnnecessaryLocalVariableInspection */
		$allowed_elements = [
			'a',
			'circle',
			'clippath',
			'defs',
			'style',
			'desc',
			'ellipse',
			'fegaussianblur',
			'filter',
			'foreignobject',
			'g',
			'image',
			'line',
			'lineargradient',
			'marker',
			'mask',
			'metadata',
			'path',
			'pattern',
			'polygon',
			'polyline',
			'radialgradient',
			'rect',
			'stop',
			'svg',
			'switch',
			'symbol',
			'text',
			'textpath',
			'title',
			'tspan',
			'use',
		];

		return $allowed_elements;
	}

	/**
	 * Remove docktype nodes.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 **/
	private function strip_doctype() {

		foreach ( $this->svg_dom->childNodes as $child ) {
			if ( XML_DOCUMENT_TYPE_NODE === $child->nodeType ) {
				$child->parentNode->removeChild( $child );
			}
		}

	}

	/**
	 * Remove php tags from string.
	 *
	 * @param $string string - The String from which all php tags will be removed.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return string
	 **/
	private function strip_php_tags( $string ) {

		$string = preg_replace( '/<\?(=|php)(.+?)\?>/i', '', $string );

		/** Remove XML, ASP, etc. */
		$string = preg_replace( '/<\?(.*)\?>/Us', '', $string );
		$string = preg_replace( '/<\%(.*)\%>/Us', '', $string );

		if ( ( false !== strpos( $string, '<?' ) ) || ( false !== strpos( $string, '<%' ) ) ) {
			return '';
		}

		return $string;
	}

	/**
	 * Remove comments from string.
	 *
	 * @param $string string - The String from which all comments tags will be removed.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return string
	 **/
	private function strip_comments( $string ) {

		/** Remove comments. */
		$string = preg_replace( '/<!--(.*)-->/Us', '', $string );
		$string = preg_replace( '/\/\*(.*)\*\//Us', '', $string );

		if ( ( false !== strpos( $string, '<!--' ) ) || ( false !== strpos( $string, '/*' ) ) ) {
			return '';
		}

		return $string;
	}

	/**
	 * Decode gzipped svg.
	 *
	 * @param $content
	 *
	 * @since 1.0.0
	 * @access private
	 * @return string
	 **/
	private function decode_svg( $content ) {
		return gzdecode( $content );
	}

	/**
	 * Check if the contents are gzipped.
	 *
	 * @param $contents
	 *
	 * @since 1.0.0
	 * @access private
	 * @return bool
	 **/
	private function is_encoded( $contents ) {

		$needle = "\x1f\x8b\x08";

		if ( function_exists( 'mb_strpos' ) ) {
			return 0 === mb_strpos( $contents, $needle );
		} else {
			return 0 === strpos( $contents, $needle );
		}

	}

	/**
	 * Return .svg uploads state.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return bool
	 **/
	public static function is_enabled() {

		static $enabled = null;

		/** Can we upload and clean .svg files? */
		if ( null === $enabled ) {
			$enabled = self::is_svg_uploads_enabled() && self::svg_sanitizer_can_run();
		}

		return $enabled;
	}

	/**
	 * Is svg uploads allowed?
	 *
	 * @since 1.0.0
	 * @access public
	 * @return bool
	 **/
	public static function is_svg_uploads_enabled() {
		/**
		 * In future this parameter will be added to plugin settings.
		 * return ! ! get_option( 'qcld_wpvm_vmwbmdp_contacter_allow_svg', false );
		 * For now, it's always true.
		 **/
		return true;
	}

	/**
	 * Can we sanitize .svg files?
	 *
	 * @since 1.0.0
	 * @access public
	 * @return bool
	 **/
	public static function svg_sanitizer_can_run() {

		return class_exists( 'DOMDocument' ) && class_exists( 'SimpleXMLElement' );

	}

	/**
	 * Allow SVG files upload.
	 *
	 * @param $allowed_types array - Allowed for uploading MIME types.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return mixed
	 **/
	public function upload_mimes( $allowed_types ) {

		/** Adding .svg extension. */
		$allowed_types['svg'] = self::MIME_TYPE;
		$allowed_types['svgz'] = self::MIME_TYPE;

		return $allowed_types;
	}

	/**
	 * Main SvgHelper Instance.
	 *
	 * Insures that only one instance of SvgHelper exists in memory at any one time.
	 *
	 * @static
	 * @return SvgHelper
	 * @since 1.0.0
	 **/
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof SvgHelper ) ) {
			self::$instance = new SvgHelper;
		}

		return self::$instance;
	}

} // End Class SvgHelper.
