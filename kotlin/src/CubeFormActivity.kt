package ep.rest

import android.content.Intent
import android.os.Bundle
import android.util.Log
import androidx.appcompat.app.AppCompatActivity
import ep.rest.databinding.ActivityCubeFormBinding
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.IOException

class CubeFormActivity : AppCompatActivity(), Callback<Void> {

    private var cube: Cube? = null

    private val binding by lazy {
        ActivityCubeFormBinding.inflate(layoutInflater)
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(binding.root)

        binding.btnSave.setOnClickListener {
            val cube_name = binding.etAuthor.text.toString().trim()
            val manufacturer = binding.etTitle.text.toString().trim()
            val price = binding.etPrice.text.toString().trim().toDouble()
            val cube_type = binding.etDescription.text.toString().trim()

            if (cube == null) {
                CubeService.instance.insert(
                    manufacturer, cube_name, price, cube_type
                ).enqueue(this)
            } else {
                CubeService.instance.update(
                    cube!!.cube_id, manufacturer, cube_name, price, cube_type
                ).enqueue(this)
            }
        }

        val cube = intent?.getSerializableExtra("ep.rest.cube") as Cube?
        if (cube != null) {
            binding.etAuthor.setText(cube.manufacturer)
            binding.etTitle.setText(cube.cube_name)
            binding.etPrice.setText(cube.price.toString())
            binding.etDescription.setText(cube.cube_type)
            this.cube = cube
        }
    }

    override fun onResponse(call: Call<Void>, response: Response<Void>) {
        val headers = response.headers()

        if (response.isSuccessful) {
            val id = if (cube == null) {
                // Preberemo Location iz zaglavja
                Log.i(TAG, "Insertion completed.")
                val parts =
                    headers.get("Location")?.split("/".toRegex())?.dropLastWhile { it.isEmpty() }
                        ?.toTypedArray()
                // spremenljivka id dobi vrednost, ki jo vrne zadnji izraz v bloku
                parts?.get(parts.size - 1)?.toInt()
            } else {
                Log.i(TAG, "Editing saved.")
                // spremenljivka id dobi vrednost, ki jo vrne zadnji izraz v bloku
                cube!!.cube_id
            }

            val intent = Intent(this, CubeDetailActivity::class.java)
            intent.putExtra("ep.rest.cube_id", id)
            startActivity(intent)
        } else {
            val errorMessage = try {
                "An error occurred: ${response.errorBody()?.string()}"
            } catch (e: IOException) {
                "An error occurred: error while decoding the error message."
            }

            Log.e(TAG, errorMessage)
        }
    }

    override fun onFailure(call: Call<Void>, t: Throwable) {
        Log.w(TAG, "Error: ${t.message}", t)
    }

    companion object {
        private val TAG = CubeFormActivity::class.java.canonicalName
    }
}
