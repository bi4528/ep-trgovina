package ep.rest

import retrofit2.Call
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import retrofit2.http.*

object BookService {

    interface RestApi {

        companion object {
            // AVD emulator
             //const val URL = "http://10.0.2.2:8080/netbeans/ep-trgovina/api/"
            // Genymotion
            //const val URL = "http://10.0.3.2:8080/netbeans/mvc-rest/api/"
            //proba
            const val URL = "http://192.168.1.71:8080/netbeans/ep-trgovina/api/"
        }

        @GET("izdelki")
        fun getAll(): Call<List<Artikel>>

        @GET("uporabniki")
        fun getAllUsers(): Call<List<User>>

        @GET("izdelki/{id}")
        fun get(@Path("id") id: Int): Call<Array<Artikel>>

        @GET("uporabniki/{id}")
        fun getUser(@Path("id") id: Int): Call<Array<User>>

//        @GET("uporabniki/{email}")
//        fun getUserByEmail(@Path("email") email: String): Call<Array<User>>

        @FormUrlEncoded
        @POST("izdelki")
        fun insert(@Field("ime") ime: String,
                   @Field("opis") opis: String,
                   @Field("cena") cena: Double,
                   @Field("prodajalec") prodajalec: String): Call<Void>

        @FormUrlEncoded
        @PUT("izdelki/{id}")
        fun update(@Path("id") id: Int,
                   @Field("ime") ime: String,
                   @Field("opis") opis: String,
                   @Field("cena") cena: Double,
                   @Field("prodajalec") prodajalec: String): Call<Void>

        @DELETE("izdelki/{id}")
        fun delete(@Path("id") id: Int): Call<Void>

        @FormUrlEncoded
        @POST("verify/{geslo}{email}")
        fun verify(@Field("geslo") geslo: String,
                   @Field("email") email: String): Call<Void>
         
    }

    val instance: RestApi by lazy {
        val retrofit = Retrofit.Builder()
                .baseUrl(RestApi.URL)
                .addConverterFactory(GsonConverterFactory.create())
                .build()

        retrofit.create(RestApi::class.java)
    }
}
