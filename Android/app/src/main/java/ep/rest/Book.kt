package ep.rest

import java.io.Serializable

data class Book(
        val id: Int = 0,
        val title: String = "",
        val year: Int = 0,
        val author: String = "",
        val description: String = "",
        val price: Double = 0.0) : Serializable
