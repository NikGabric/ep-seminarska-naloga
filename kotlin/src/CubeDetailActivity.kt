package ep.rest

import android.app.AlertDialog
import android.content.Intent
import android.os.Bundle
import android.util.Log
import androidx.appcompat.app.AppCompatActivity
import ep.rest.databinding.ActivityCubeDetailBinding
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.IOException

class CubeDetailActivity : AppCompatActivity() {
    private var cube: Cube = Cube()
    val binding by lazy {
        ActivityCubeDetailBinding.inflate(layoutInflater)
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(binding.root)
        setSupportActionBar(binding.toolbar)

        binding.fabEdit.setOnClickListener {
            val intent = Intent(this, CubeFormActivity::class.java)
            intent.putExtra("ep.rest.cube", cube)
            startActivity(intent)
        }

        binding.fabDelete.setOnClickListener {
            val dialog = AlertDialog.Builder(this)
            dialog.setTitle("Confirm deletion")
            dialog.setMessage("Are you sure?")
            dialog.setPositiveButton("Yes") { _, _ -> deleteCube() }
            dialog.setNegativeButton("Cancel", null)
            dialog.create().show()
        }


        supportActionBar?.setDisplayHomeAsUpEnabled(true)

        val cube_id = intent.getIntExtra("ep.rest.cube_id", 0)

        if (cube_id > 0) {
            CubeService.instance.get(cube_id).enqueue(OnLoadCallbacks(this))
        }
    }
    private fun deleteCube() {
        val id = intent.getIntExtra("ep.rest.cube_id", 0)
        if (id > 0) {
            CubeService.instance.delete(id).enqueue(OnDeleteCallbacks(this))
        }
    }

    private class OnDeleteCallbacks(val activity: CubeDetailActivity) : Callback<Void> {
        private val tag = this::class.java.canonicalName

        override fun onResponse(call: Call<Void>, response: Response<Void>) {
            Log.i(tag, "Successfully deleted item.")
            activity.startActivity(Intent(activity, MainActivity::class.java))
        }

        override fun onFailure(call: Call<Void>, t: Throwable) {
            Log.w(tag, "Error: ${t.message}", t)
        }
    }

    private class OnLoadCallbacks(val activity: CubeDetailActivity) : Callback<Cube> {
        private val tag = this::class.java.canonicalName

        override fun onResponse(call: Call<Cube>, response: Response<Cube>) {
            activity.cube = response.body() ?: Cube()

            Log.i(tag, "Got result: ${activity.cube}")

            if (response.isSuccessful) {
                activity.binding.includer.tvCubeType.text = "Cube type: " + activity.cube.cube_type + "\nManufacturer: " + activity.cube.manufacturer + "\nPrice: " + activity.cube.price.toString() + " Eur"
                activity.binding.toolbarLayout.title = activity.cube.cube_name
            } else {
                val errorMessage = try {
                    "An error occurred: ${response.errorBody()?.string()}"
                } catch (e: IOException) {
                    "An error occurred: error while decoding the error message."
                }

                Log.e(tag, errorMessage)
                activity.binding.includer.tvCubeType.text = errorMessage
            }
        }

        override fun onFailure(call: Call<Cube>, t: Throwable) {
            Log.w(tag, "Error: ${t.message}", t)
        }
    }
}

