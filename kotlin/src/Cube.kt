package ep.rest

import java.io.Serializable

data class Cube(
        val cube_id: Int = 0,
        val cube_name: String = "",
        val manufacturer: String = "",
        val cube_type: String = "",
        val price: Double = 0.0) : Serializable
