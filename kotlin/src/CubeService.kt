package ep.rest

import retrofit2.Call
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import retrofit2.http.*

object CubeService {

    interface RestApi {

        companion object {
            // AVD emulator
            const val URL = "http://10.0.2.2/ep/php/api/"
//            const val URL = "https://192.168.1.34/ep/php/api/"
            // Genymotion
            // const val URL = "http://10.0.3.2:8080/netbeans/mvc-rest/api/"
        }

        @GET("cubes")
        fun getAll(): Call<List<Cube>>

        @GET("cubes/{cube_id}")
        fun get(@Path("cube_id") cube_id: Int): Call<Cube>

        @DELETE("cubes/{cube_id}")
        fun delete(@Path("cube_id") id: Int): Call<Void>

        @FormUrlEncoded
        @POST("cubes")
        fun insert(@Field("cube_name") cube_name: String,
                   @Field("manufacturer") manufacturer: String,
                   @Field("price") price: Double,
                   @Field("cube_type") cube_type: String): Call<Void>

        @FormUrlEncoded
        @POST("cubes/{cube_id}")
        fun update(@Path("cube_id") cube_id: Int,
                   @Field("cube_name") cube_name: String,
                   @Field("manufacturer") manufacturer: String,
                   @Field("price") price: Double,
                   @Field("cube_type") cube_type: String): Call<Void>

    }

    val instance: RestApi by lazy {
        val retrofit = Retrofit.Builder()
                .baseUrl(RestApi.URL)
                .addConverterFactory(GsonConverterFactory.create())
                .build()

        retrofit.create(RestApi::class.java)
    }
}
