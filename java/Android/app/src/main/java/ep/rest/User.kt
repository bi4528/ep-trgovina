package ep.rest

import java.io.Serializable

data class User(
        val id: Int = 0,
        val ime: String = "",
        val priimek: String = "",
        val email: String = "",
        val geslo: String = "",
        val naslov: String = "",
        val vloga: String = "",
        val aktiven: Int = 0
) : Serializable

