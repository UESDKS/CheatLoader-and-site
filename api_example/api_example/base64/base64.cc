#include "base64.hh"

#undef max

static const char b64_table[ 65 ] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
auto c_base64::encrypt( std::string bin ) -> std::string {
    using ::std::string;
    using ::std::numeric_limits;

    if ( bin.size( ) > ( numeric_limits<string::size_type>::max( ) / 4u ) * 3u ) {

    }

    const ::std::size_t binlen = bin.size( );
    // Use = signs so the end is properly padded.
    string retval( ( ( ( binlen + 2 ) / 3 ) * 4 ), '=' );
    ::std::size_t outpos = 0;
    int bits_collected = 0;
    unsigned int accumulator = 0;
    const string::const_iterator binend = bin.end( );

    for ( string::const_iterator i = bin.begin( ); i != binend; ++i ) {
        accumulator = ( accumulator << 8 ) | ( *i & 0xffu );
        bits_collected += 8;
        while ( bits_collected >= 6 ) {
            bits_collected -= 6;
            retval[ outpos++ ] = b64_table[ ( accumulator >> bits_collected ) & 0x3fu ];
        }
    }
    if ( bits_collected > 0 ) { // Any trailing bits that are missing.
        accumulator <<= 6 - bits_collected;
        retval[ outpos++ ] = b64_table[ accumulator & 0x3fu ];
    }
    return retval;
}