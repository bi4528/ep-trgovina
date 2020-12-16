package ep.rest

import java.io.Serializable
//import java.sql.RowId

data class Artikel(
        val prodajalec: String = "",
        val ime: String = "",
        val opis: String = "",
        val cena: Double = 0.0,
        val id: Int = 0,


        //val price: Double = 0.0,
        //val aktiven: Boolean = false
) : Serializable
